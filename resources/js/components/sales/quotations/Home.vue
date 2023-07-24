<template>
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row invoice-add">
      <!-- Invoice Add-->
      <div class="col-lg-9 col-12 mb-lg-0 mb-4">
        <div class="card invoice-preview-card">
          <div class="card-body">
            <div class="row p-sm-1 p-0">
              <div class="col-md-6 mb-md-0 mb-4">
                <div class="d-flex svg-illustration mb-4 gap-2">
                  <span class="app-brand-logo demo">
                    <svg width="25" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg"
                      xmlns:xlink="http://www.w3.org/1999/xlink">
                      <defs>
                        <path
                          d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                          id="path-1"></path>
                        <path
                          d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                          id="path-3"></path>
                        <path
                          d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                          id="path-4"></path>
                        <path
                          d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                          id="path-5"></path>
                      </defs>
                      <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                          <g id="Icon" transform="translate(27.000000, 15.000000)">
                            <g id="Mask" transform="translate(0.000000, 8.000000)">
                              <mask id="mask-2" fill="white">
                                <use xlink:href="#path-1"></use>
                              </mask>
                              <use fill="#696cff" xlink:href="#path-1"></use>
                              <g id="Path-3" mask="url(#mask-2)">
                                <use fill="#696cff" xlink:href="#path-3"></use>
                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                              </g>
                              <g id="Path-4" mask="url(#mask-2)">
                                <use fill="#696cff" xlink:href="#path-4"></use>
                                <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                              </g>
                            </g>
                            <g id="Triangle"
                              transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) ">
                              <use fill="#696cff" xlink:href="#path-5"></use>
                              <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                            </g>
                          </g>
                        </g>
                      </g>
                    </svg>
                  </span>
                  <span class="h3 mt-2 demo text-body fw-bolder">Nueva Cotización</span>
                </div>
              </div>
              <div class="col-md-6">
                <dl class="row mb-2">

                  <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                    <span class="fw-normal">Fecha:</span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end">
                    <div class="w-px-150">
                      <input type="date" class="form-control date-picker flatpickr-input" v-model="quotation.date">
                    </div>
                  </dd>
                  <dt class="col-sm-6 mb-2 mb-sm-0 text-md-end">
                    <span class="fw-normal">Fecha de validez:</span>
                  </dt>
                  <dd class="col-sm-6 d-flex justify-content-md-end">
                    <div class="w-px-150">
                      <input type="date" class="form-control date-picker flatpickr-input"
                        v-model="quotation.expiration_date">
                    </div>
                  </dd>
                </dl>
              </div>
            </div>
            <hr class="my-4 mx-n4">
            <div class="row p-sm-3 p-0">
              <div class="d-flex justify-content-between align-items-center">
                <h6 class="pb-2">Cotización para:</h6>
                <div class="">
                  <button class="btn btn-primary" @click="showSearchBar">+</button>
                  <input type="text" v-show="showBar" v-model="search" class="form-control" @keyup="searchCustomer">
                  <table>
                    <ul class="list-group" v-for="customerFound in customersFound">
                      <li class="list-group-item d-flex justify-content-between align-items-center cursor-pointer"
                        @click="addCustomer(customerFound)">{{ customerFound.name }}</li>
                    </ul>
                  </table>
                </div>

              </div>

              <div class="col-md-4 col-sm-5 col-12 mb-sm-0 mb-4" v-for="customer in customers">
                <div class="card shadow-none bg-transparent border border-primary mb-3">
                  <div class="card-body">
                    <h5 class="card-title">{{ customer.name }}
                      <i @click="deleteCustomer(customer.id)" class='text-danger bx bx-trash'></i>
                    </h5>

                    <p class="card-text">
                    <table>
                      <tbody>
                        <tr>
                          <td>{{ customer.university }}</td>
                        </tr>
                        <tr>

                          <td>{{ customer.career }}</td>
                        </tr>
                        <tr>

                          <td>{{ customer.cell }}</td>
                        </tr>
                        <tr>

                          <td>{{ customer.email }}</td>
                        </tr>
                      </tbody>
                    </table>
                    </p>
                  </div>
                </div>

              </div>
              <div class="col-md-6 col-sm-7"></div>
            </div>
            <hr class="mx-n4">
            <form class="source-item py-sm-3">
              <div class="row">
                <div class="col-12">
                  <button type="button" class="btn btn-primary" data-repeater-create="" @click="addDetail">Agregar
                    Detalle</button>
                </div>
              </div>
              <div class="mb-3" data-repeater-list="group-a">
                <template v-for="(detail, index) in details">
                  <Detail :detail="detail" :newProducts="newProducts" :index="index"
                    @removeSuggestedCart="removeSuggestedCart" />
                </template>
              </div>
            </form>
            <hr class="my-4 mx-n4">
            <div class="row py-sm-3">
              <div class="col-md-6 mb-md-0 mb-3">
                <div class="d-flex align-items-center mb-3">
                  <label for="salesperson" class="form-label me-5 fw-semibold">Tiempo de Ejecución<span
                      class="text-danger">*</span>:</label>
                  <input type="text" class="form-control" v-model="quotation.term">
                </div>
                <div class="d-flex align-items-center mb-3">
                  <label for="salesperson" class="form-label me-5 fw-semibold">Cupón de descuento:</label>
                  <input type="text" class="form-control" v-model="coupon" @keyup.enter="autoDiscount">
                </div>
              </div>
              <div class="col-md-6 d-flex justify-content-end">
                <div class="invoice-calculations">
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-100">Subtotal:</span>
                    <span class="fw-semibold">S./ {{ totalProducts }}</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                    <span class="w-px-100">Descuento:</span>
                    <span class="fw-semibold">S./ {{ quotation.discount }}</span>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between">
                    <span class="w-px-100">Total:</span>
                    <span class="fw-semibold">S./ {{ finalPrice }}</span>
                  </div>
                </div>
              </div>
            </div>
            <hr class="my-4 mx-n4">
            <div class="row">
              <div class="col-12">
                <div class="mb-3">
                  <label for="note" class="form-label fw-semibold">Nota:</label>
                  <textarea class="form-control" rows="2" id="note" v-model="quotation.note"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /Invoice Add-->

      <!-- Invoice Actions -->
      <div class="col-lg-3 col-12 invoice-actions">
        <div class="card bg-success text-white mb-3">
          <div class="card-header">
            Necesidades del cliente
          </div>
          <div class="card-body">
            <p v-for="customer in customers">{{ customer.needs }}</p>
          </div>
        </div>
        <div class="card mb-4">
          <div class="card-body">
            <button @click="createQuotation" class="btn btn-primary d-grid w-100 mb-3">
              <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                  class="bx bx-paper-plane bx-xs me-1"></i>Generar</span>
            </button>
            <router-link v-if="quotationIdGenerated != 0"
              :to="{ name: 'quotation-file', params: { id: quotationIdGenerated } }" target="_blank"
              class="btn btn-primary d-grid w-100 mb-3" disabled>
              <span class="d-flex align-items-center justify-content-center text-nowrap">
                <i class="bx bx-file bx-xs me-1"></i>Cotización
              </span>
            </router-link>
          </div>
        </div>
      </div>
      <!-- /Invoice Actions -->
    </div>
  </div>
</template>
<script>
import moment from 'moment'
import CustomerCard from './CustomerCard.vue'
import DateCard from './DateCard.vue'
import calcModal from './calcModal.vue'
import InsertDetail from './InsertDetail.vue'
import SearchProduct from './searchProduct.vue'
import ProductModal from './ProductModal.vue'
import { userStore } from '../../../stores/UserStore'
import Detail from './Detail.vue'
import Payments from './Payments.vue'
import axios from 'axios'

export default {
  setup() {
    const store = userStore()
    return {
      store
    }
  },
  components: { calcModal, InsertDetail, CustomerCard, DateCard, SearchProduct, ProductModal, Detail, Payments },
  data() {
    return {
      showBar: false,
      quotation: {
        id: 0,
        customer_id: 0,
        date: '',
        amount: 0,
        term: '',
        expiration_date: '',
        discount: 0,
        note: ''
      },
      search: '',
      customersFound: [],
      customer: {
        name: '',
        cell: '',
        university: '',
        career: '',
        status: 0,
        email: '',
        needs: ''
      },
      customers: [],
      details: [],
      discount: 0,
      newProducts: [],
      coupon: '',
      recentsCode: [],
      quotationIdGenerated: 0
    }
  },
  methods: {
    deleteCustomer(customerId) {
      var customerSelected = this.customers.findIndex(customer => customer.id == customerId);
      this.customers.splice(customerSelected, 1)
    },
    showSearchBar() {
      this.showBar = !this.showBar
    },
    addCustomer(customer) {
      this.customers.push(customer);
      this.customersFound = [];
      this.search = ''
    },
    searchCustomer() {
      if (this.search.length == 3) {
        axios.get('/api/customers/search/' + this.search)
          .then((result) => {
            this.customersFound = result.data.customers
          }).catch((err) => {
            console.error(err)
          });
      } else if (this.search.length > 3) {
        this.customersFound = this.customersFound.filter(customer => customer.name.toLowerCase().includes(this.search))
      } else if (this.search.length == 0) {
        this.customersFound = []
      }
    },
    getQuotation() {
      axios.get('/api/quotations/' + this.$route.params.idQuotation)
        .then((res) => {
          console.log(res);
          this.quotation = res.data[0]
          this.customers = this.quotation.customers
          this.details = this.quotation.details
          /* if (this.customer.quotations[0]) {
            this.quotation = this.customer.quotations[0]
            this.customer.quotations[0].details.forEach(detail => {
              this.details.push(detail)
            })
          } */
        })
        .catch((err) => {
          console.log(err)
        })
    },
    getUser() {
      axios.get('/api/getCustomer/' + this.$route.params.idCustomer)
        .then((res) => {
          this.customer = res.data
          this.customers.push(this.customer)
          if (this.customer.quotations[0]) {
            this.quotation = this.customer.quotations[0]
          }
        })
        .catch((err) => {
          console.log(err)
        })
    },
    autoDiscount() {

      axios.get('/api/promotions/' + this.coupon)
        .then((result) => {
          console.log(result)
          if (Object.keys(result.data).length == 0) {
            this.$swal('Código Incorrecto')
          }
          else if (result.data.percent == 0) {
            this.$swal('Se ha desbloqueado el descuento por cantidad')
            this.quotation.discount = result.data.quantity
          } else {
            this.$swal('Se ha desbloqueado el descuento por porcentaje')
            this.quotation.discount = ((this.totalProducts * codeFound.percent) / 100).toFixed(2)
          }
        }).catch((err) => {

        });

      /* var codeFound = this.recentsCode.find(code => code.code == this.coupon)
      if (codeFound && codeFound.percent == 0 && this.quotation.discount == 0) {
       
        this.quotation.discount = ((this.totalProducts - codeFound.quantity) / 100).toFixed(2)
      } else if (codeFound && codeFound.quantity == 0 && this.quotation.discount == 0) {
        
        
      } else {
        this.$swal('Codigo incorrecto o duplicado')
        this.quotation.discount = 0
      } */
    },
    addDetail() {
      this.details.push({ type: 1, level: '', title: '', mode: '', price: '', product: { name: '' }, product_id: '' })
    },
    getAllNewProducts() {
      axios.get('/api/getAllNewProducts')
        .then((res) => {
          this.newProducts = res.data
        })
        .catch((err) => {
          console.error(err)
        })
    },
    removeSuggestedCart(index) {
      this.details.splice(index, 1)
    },
    insertQuotation() {
      if (this.customer.quotations[0]) {
        this.updateQuotation(this.customer.quotations[0].id)
      } else {
        this.createQuotation()
      }
    },
    updateQuotation(quotationId) {
      if (this.quotation.discount == null) {
        this.quotation.discount = 0.0
      }
      const fd = new FormData()

      fd.append('quotation_id', quotationId)
      fd.append('date', this.quotation.date)
      fd.append('expirationDay', this.quotation.expiration_date)
      fd.append('amount', this.totalProducts - this.quotation.discount)
      fd.append('discount', this.quotation.discount)
      fd.append('term', this.quotation.term)
      fd.append('products', JSON.stringify(this.details))
      fd.append('emisor_id', this.store.authUser.id)
      fd.append('coupon', this.coupon)

      axios.post('/api/updateQuotation', fd)
        .then((res) => {
          this.$swal('Cotización actualizada correctamente')
          this.idQuotation = res.data.id
        })
        .catch((err) => {
          console.log(err);
          this.$swal(err.response.data)
          console.log(err)
        })
    },
    createQuotation() {
      if (this.quotation.date == '' || this.quotation.expiration_date == '' || this.quotation.term == '') {
        this.$swal('Porfavor no deje en blanco los campos de fecha, tiempo de ejecución y fecha de validez')
      } else {
        const fd = new FormData()

        fd.append('user_id', this.store.authUser.id)
        fd.append('customers', JSON.stringify(this.customers))
        fd.append('customer_id', this.customer.id)
        fd.append('date', this.quotation.date)
        fd.append('expirationDay', this.quotation.expiration_date)
        fd.append('amount', (this.totalProducts - this.quotation.discount).toFixed(2))
        fd.append('discount', this.quotation.discount)
        fd.append('term', this.quotation.term)
        fd.append('products', JSON.stringify(this.details))
        fd.append('emisor_id', this.store.authUser.id)
        fd.append('coupon', this.coupon)

        axios.post('/api/quotations', fd)
          .then((res) => {
            this.$swal('Cotización insertada correctamente')
            this.quotationIdGenerated = res.data.id
          })
          .catch((err) => {
            this.$swal(err.response.data)
            console.log(err)
          })
      }
    },
    getAllPromotionCodes() {
      axios.get('/api/getAllPromotionsCode')
        .then((res) => {
          this.recentsCode = res.data
        })
        .catch((err) => {
          console.error(err)
        })
    }
  },
  mounted() {
    this.getAllPromotionCodes()
    this.getUser()
    this.getAllNewProducts()
  },
  computed: {
    finalPrice() {
      return (this.totalProducts - this.quotation.discount).toFixed(2)
    },
    totalProducts() {
      var total = 0
      this.details.forEach((product) => {
        if (product.type == 1) {
          total += parseFloat(product.price)
        }

      })
      return (total).toFixed(2)
    }
  }
}
</script>