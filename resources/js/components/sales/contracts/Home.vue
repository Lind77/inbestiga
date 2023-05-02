<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1">Contrato</h4>
    <div class="col-xl-12">
      <div class="alert alert-warning alert-dismissible" role="alert">
          Atención! Los detalles de este contrato están asociados a la última
          <span class="fw-bold cursor-pointer" @click="toQuotation">cotización</span>
          de este cliente
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Verifique los datos para generar el contrato.</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <ClientSection :customerSelected="customerSelected" @updateCustomer="updateCustomer"/>
            </div>
            <div class="col">
              <div class="card shadow-none bg-transparent border border-info mb-3">
                <div class="card-body">
                  <div class="mb-3">
                    <label class="form-label" for="basic-default-company">Fecha</label>
                    <input type="date" v-model="date" class="form-control" id="basic-default-company" />
                  </div>
                  <div class="mb-3">
                    <div v-if="countSugestedProducts != 0" class="form-check mt-3">
                    <input @click="considerSugested" class="form-check-input" type="checkbox" id="defaultCheck1">
                    <label class="form-check-label" for="defaultCheck1">
                      Considerar Sugeridos
                    </label>
                  </div>
                  </div>
              </div>
              </div>
            </div>
          </div>
            <div class="table-responsive text-nowrap">
              <table class="table">
                <thead class="table-primary">
                  <tr>
                    <th>Producto/Servicio</th>
                    <th>Tipo</th>
                    <th>Precio</th>
                  </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                  <template v-for="(detail, index) in details">
                    <tr v-if="detail.type <= detail_type">
                      <td>{{ detail.new_product.name }}</td>
                      <td>{{ detail.type == 1? 'Normal':'Sugerido' }}</td>
                      <td>S./ {{ detail.price }}</td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
            <div class="row">
                    <div class="col-6">
                      <div class="mb-3">
                        <label class="form-label" for="basic-default-company">Descuento</label>
                        <input type="text" class="form-control" v-model="discount">
                      </div>
                    </div>
                  <div class="col-6">
                    <div class="mb-3">
                      <label class="form-label" for="basic-default-company">TOTAL FINAL:</label>
                      <br>
                      S./ {{ totalFinal.toFixed(2) }}
                    </div>
                  </div>
                  </div>
            <div class="row">
              <div class="col-xl">
                <h5 class="mb-0">Pagos y entregas <span class="badge bg-label-primary me-1 cursor-pointer" @click="openFeesModal()">+</span></h5>
                <div class="row mt-3">
                  <div class="col-3" v-for="fee in fees">
                    <div class="card shadow-none bg-transparent border border-success p-3">
                      <p class="text-danger cursor-pointer" @click="removeFee(fee.id)"><i class="bx bx-trash"></i></p>
                      <p>Fecha: {{ fee.date }}</p>
                      <p>Monto: S./ {{ fee.amount }}</p>
                      <p>Porcentaje: {{ fee.percentage }} %</p>
                      <p>Avance: {{ fee.advance }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <button @click="insertContract" class="btn btn-primary mt-2 text-white">Guardar</button>
            <a v-if="idContract != 0" :href="`../../api/generateContract/${$route.params.idUser}`" target="_blank" class="btn btn-primary mt-2 mx-2 text-white" disabled>PDF</a>
        </div>
      </div>
    </div>
  <!--  <PaymentModal @addPayment="addPayment"/> -->
  
        <!-- Basic Layout -->
        
        <!-- <calcModal @addCartParaphrase="addCartParaphrase"/> -->
        <!-- <InsertDetail @addCartModal="addCartModal" @addSugestCartModal="addSugestCartModal" :product="selected_product" :products="fixed_products"/> -->
        <FeesModal @addFee="addFee" :totalFinal="totalFinal"/>
  </div>
</template>
<script>
      import conversor from 'conversor-numero-a-letras-es-ar'
      import ClientSection from './ClientSection.vue'
      import FeesModal from './FeesModal.vue'
      import axios from 'axios'
      import moment from 'moment'
      import {userStore} from '../../../stores/UserStore'
      /* import List from './List.vue'
      import PaymentModal from './PaymentModal.vue' */
     /*  import calcModal from './calcModal.vue' */
     /*  import InsertDetail from './InsertDetail.vue' */
      export default{
        setup(){
          const store = userStore()
          return { store }
        },
        components:{ClientSection, FeesModal},
        data(){
          return{
            fees:[],
            address:'',
            payments: [],
            detail_type: 1,
            total:0,
            quotation:{},
            final_delivery:'',
            observations:'',
            dni:'',
            customers:[],
            term:'',
            customersFiltered:[],
            customerSelected:{},
            discount:0,
            products:[],
            fixed_products:[],
            selected_product:{},
            filtered_products:[],
            filtered_products_sugested:[],
            car_products:[],
            carSugestedProducts:[],
            details:[],
            name: '',
            date:null,
            cell:'',
            searchProduct:'',
            searchSugestedProduct:'',
            university:'',
            career:'',
            grade:0,
            idContract:0,
            idOrder:0,
            level: 0,
            levelSugested: 0,
            price: [],
            status:{
              0: 'No atendido',
              1: 'Atendido',
              2: 'Comunicación establecida',
              3: 'Lead',
              4: 'Interesado',
              5: 'Altamente Interesado',
              6: 'Cliente',
              null: 'Stand By'
            }
          }
        },
        methods:{
          toQuotation(){
            this.$router.push({name:'home-quotation', params:{ idUser: this.customerSelected.id }});
          },
          addFee(fee){
            
            fee.amount = fee.amount
            this.fees.push(fee)
          },
          removeFee(feeId){
          var feedIndex =  this.fees.findIndex(fee => fee.id == feeId)
          this.fees.splice(feedIndex, 1)
          },
          updateCustomer(){
            this.getCustomer()
          },
          addPayment(payment){
            this.payments.push(payment);
          },
          openFeesModal(){
            $('#feesModal').modal('show')
          },
          considerSugested(){
            this.detail_type = (this.detail_type === 1) ? 2 : 1
          },
          generatePDF(){
    
            const fd =  new FormData()
          
            fd.append('customer', this.customerSelected)
            fd.append('date', this.date)
            fd.append('expirationDay', finalDayMonth)
            fd.append('products', this.car_products)
            fd.append('suggestedProducts', this.suggested_products)
            fd.append('discount', this.discount)
    
            axios.post('/api/quotationPDF', fd)
            .then(res => {
              console.log(res)
            })
            .catch(err => {
              console.log(err)
            })
          },
          selectCustomer(customer){
            this.customerSelected = customer
            this.customersFiltered = []
            this.name = ''
          },
          deleteCustomerSelected(){
            this.customerSelected = {}
          },
          print(e){
                e.preventDefault()
                window.open('/api/generatePDF/'+this.idQuotation)
          },
          insertContract(){
            if(this.date == null){
              this.$swal('Porfavor agregar la fecha de cotización')
            }else if(this.totalFinal != this.sumTotalFees){
              console.log(this.totalFinal, this.sumTotalFees)
              this.$swal('El monto final y el monto de los pagos no coincide')
            }else{
              let conversorClass = conversor.conversorNumerosALetras
              let myConverter = new conversorClass()

              const fd =  new FormData()
              fd.append('quotation_id', this.quotation.id)
              fd.append('amount', parseInt(this.totalFinal))
              fd.append('amount_text',myConverter.convertToText(parseInt(this.totalFinal)))
              fd.append('date', this.date)
              fd.append('fees', JSON.stringify(this.fees))
              fd.append('customer_id', this.$route.params.idUser)
              fd.append('user_id', this.store.authUser.id)
            
              axios.post('/api/insertContract', fd)
              .then(res =>{
                this.idContract = res.data
                this.$swal('Contrato generado correctamente')
                document.getElementById('buttonPDF').disabled = false
              })
              .catch(err =>{
                console.log(err)
              })
            }
          },
          insertOrder(){
            var sumTotalPayments = 0
            this.payments.forEach(payment =>{
              sumTotalPayments += parseFloat(payment.amount)
            })
            if(this.totalFinal != sumTotalPayments){
              this.$swal('El monto final y el monto de los pagos no coincide')
            }
            else if(this.date == null){
              this.$swal('Porfavor agregar la fecha de cotización')
            }else{
              const fd =  new FormData()
          
            fd.append('quotation_id', this.quotation.id)
            fd.append('final_delivery', this.final_delivery)
            fd.append('observations', this.observations)
            fd.append('suggested', this.detail_type)
            fd.append('payments', JSON.stringify(this.payments))
            fd.append('discount', this.discount)
    
            axios.post('/api/insertOrder',fd)
            .then(res =>{
              console.log(res)
    
              this.idOrder = res.data
              this.$swal('Orden almacenada correctamente')
              document.getElementById('buttonPDF').disabled = false
            })
            .catch(err =>{
              console.error(err)
            })
            } 
            
          },
          addCartParaphrase(cost){
            this.selected_product.amount = cost
            this.car_products.push(this.selected_product)
            this.filtered_products = []
            const objWithIdIndex = this.products.findIndex((obj) => obj.id === 41)
            this.products.splice(objWithIdIndex,1)
            document.getElementById('inputSearch').value = ''
            document.getElementById('inputSearch').focus()
          },
          addCartModal(product){
            this.car_products.push(JSON.stringify(product))
            this.filtered_products = []
            this.searchProduct = ''
          },
          addSugestCartModal(product){
            this.carSugestedProducts.push(JSON.stringify(product))
            this.filtered_products_sugested = []
            this.searchSugestedProduct = ''
          },
          addCart(product){
            if(this.level == 0){
              this.$swal('Selecciona un nivel, por favor')
            }else{
            if(product.id == 41){
              this.selected_product = product
              $('#calcModal').modal('show')
            }else{
              this.selected_product = product
              this.selected_product.level = this.level
              this.selected_product.typeOp = 1
              $('#insertDetailModal').modal('show')
              /* this.filtered_products = []
              var selectedProduct = {}
    
              selectedProduct = product
    
              let price =  selectedProduct.prices.filter(prices => prices.level == this.level)[0].price
    
              selectedProduct.id_product = product.id
              selectedProduct.level = this.level
              selectedProduct.amount = price
    
              this.car_products.push(JSON.stringify(selectedProduct))
    
              this.searchProduct = '' */
            }
            }
          },
          addCartSuggested(product){
            if(this.levelSugested == 0){
              this.$swal('Selecciona un nivel en producto sugerido, por favor')
            }else{
            if(product.id == 41){
              this.selected_product = product
              $('#calcModal').modal('show')
            }else{
              this.selected_product = product
              this.selected_product.level = this.levelSugested
              this.selected_product.typeOp = 2
              $('#insertDetailModal').modal('show')
              /* this.filtered_products_sugested = []
              var selectedProduct = {}
    
              selectedProduct = product
              selectedProduct.id_product = product.id
              selectedProduct.level = this.level
              selectedProduct.amountLevel = product.amountLevel
    
              this.carSugestedProducts.push(JSON.stringify(selectedProduct))
    
              this.searchSugestedProduct = '' */
            }
            }
          },
          removeCart(product){
            this.car_products.splice(product,1)
            console.log(product)
          },
          removeSuggestedCart(product){
            this.carSugestedProducts.splice(product,1)
            console.log(product)
          },
          searchSugested(e){
            if(e.target.value != '' && this.levelSugested != 0){
    
              var productsFound = this.products.filter(product => product.title.toLowerCase().includes(e.target.value))
    
              productsFound.forEach(product => {
                product.amountLevel = product.prices.filter(price => price.level == this.levelSugested)[0].price
              })
    
              this.filtered_products_sugested = productsFound
            }else{
              this.filtered_products_sugested = [] 
            }
          },
          search(e){
            if(e.target.value != '' && this.level != 0){
              var productsFound = this.products.filter(product => product.title.toLowerCase().includes(e.target.value))
              productsFound.forEach(product => {
                product.amountLevel = product.prices.filter(price => price.level == this.level)[0].price
              })
    
              this.filtered_products = productsFound
            }else{
              this.filtered_products = [] 
            }
          },
          searchCustomer(e){
            console.log(e.target.value)
            if(e.target.value != ''){
              this.customersFiltered = this.customers.filter(customer => customer.name.toLowerCase().includes(e.target.value))
            }else{
              this.customersFiltered = [] 
            }
          },
          getAllProducts(){
            axios.get('/api/getAllProducts')
            .then(res =>{
              this.products = res.data
              this.fixed_products = res.data
            })
            .catch(err =>{
              console.log(err.response.data)
            })
          },
          getCustomer(){
            this.$swal('Cargando ...')
            axios.get('/api/getCustomer/'+this.$route.params.idUser)
            .then(res => {
              this.customerSelected = res.data
              this.$swal.close()
            })
          },
          getQuotation(){
            axios.get(`/api/getQuotationByCustomerId/${this.$route.params.idUser}`)
            .then(res => {
              console.log(res.data)
              this.quotation = res.data
              this.details = res.data.details
              this.discount = res.data.discount
            })
            .catch(err => { console.error(err.data.message)})
          },
          getOrders(){
            this.$refs.ordersList.getAllOrders()
          }
        },
        mounted(){
          this.getAllProducts()
          this.getCustomer()
          this.getQuotation()
        },
        computed:{
          totalFinal(){
            var sumMonto = 0
            if(this.detail_type == 1){
              this.details.forEach(detail =>{
                  if(detail.type == 1){
                    sumMonto += parseFloat(detail.price)
                  }
              })
              return parseFloat(sumMonto).toFixed(0) - parseFloat(this.discount).toFixed(0)
            }else{
              this.details.forEach(detail =>{
                  if(detail.type <= 2){
                    sumMonto += parseFloat(detail.price)
                  }
              })
              return parseFloat(sumMonto).toFixed(0) - parseFloat(this.discount).toFixed(0) 
            }
          },
          countSugestedProducts(){
            if(this.quotation.details){
              var numSugested = 0
              this.quotation.details.forEach(detail =>{
                if(detail.type == 2){
                  numSugested ++
                }
              })
              return numSugested
            }
          },
          finalDayMonthFormatted(){
            return moment().endOf('month').format('YYYY-MM-DD')
          },
          finalDayMonth(){
            return moment().endOf('month').format('DD/MM/YYYY')
          },
          totalProducts(){
            var total = 0
            this.car_products.forEach((product)=>{
                total += JSON.parse(product).total
            })
    
            return Math.round(total * 100)/100
          },
          totalSuggestedProducts(){
            var total = 0
            this.carSugestedProducts.forEach((product)=>{
                total += JSON.parse(product).total
            })
    
            return Math.round(total * 100)/100
          },
          sumTotalFees(){
            var total = 0
            this.fees.forEach((fee)=>{
              total += fee.amount
            })

            return total
          }
        }
      }
    </script>