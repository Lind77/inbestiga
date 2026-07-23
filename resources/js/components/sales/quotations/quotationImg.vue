<template>
    <div class="quotation-wrapper d-flex justify-content-center align-items-center py-4">
        <div class="page" v-if="quotationObj">
            <!-- Top Header with Diagonal Black Polygon & Right Quotation Info -->
            <header class="header-section">
                <!-- Left Polygon Header -->
                <div class="header-left-polygon">
                    <div class="brand-content">
                        <!-- AG Logo -->
                        <div class="logo-container">
                            <svg width="45" height="45" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
                                </defs>
                                <use fill="#FFFFFF" xlink:href="#path-1"></use>
                            </svg>
                        </div>
                        <div class="brand-text-group">
                            <h1 class="brand-title">AVANTAGE</h1>
                            <div class="brand-subtitle-line">
                                <span class="group-tag">G R O U P</span>
                            </div>
                            <p class="brand-services">INNOVACIÓN • INVESTIGACIÓN<br>SOFTWARE • MARKETING</p>
                        </div>
                    </div>
                </div>

                <!-- Right Header Details -->
                <div class="header-right-info">
                    <h2 class="doc-main-title">COTIZACIÓN</h2>
                    <p class="doc-code">CTZ-{{ String(quotationObj.id).padStart(4, '0') }}</p>
                    
                    <div class="meta-list">
                        <div class="meta-item">
                            <svg class="meta-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                            <div class="meta-text">
                                <span class="meta-label">FECHA:</span>
                                <span class="meta-value">{{ quotationObj.date }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <svg class="meta-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <div class="meta-text">
                                <span class="meta-label">VÁLIDO HASTA:</span>
                                <span class="meta-value">{{ quotationObj.expiration_date }}</span>
                            </div>
                        </div>
                        <div class="meta-item">
                            <svg class="meta-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            <div class="meta-text">
                                <span class="meta-label">ELABORADO POR:</span>
                                <span class="meta-value">Avantage Group</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Customer & Presentation 2-Column Section -->
            <section class="info-section">
                <!-- Column 1: Datos del Cliente -->
                <div class="info-col customer-col">
                    <h3 class="section-title">DATOS DEL CLIENTE</h3>
                    <div class="data-group">
                        <div class="data-item" v-if="customerObj.name">
                            <svg class="data-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <div>
                                <strong>Cliente:</strong>
                                <span>{{ customerObj.name }}</span>
                            </div>
                        </div>
                        <div class="data-item" v-if="customerObj.address">
                            <svg class="data-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <div>
                                <strong>Dirección:</strong>
                                <span>{{ customerObj.address }}</span>
                            </div>
                        </div>
                        <div class="data-item" v-if="customerObj.email">
                            <svg class="data-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <div>
                                <strong>Correo:</strong>
                                <span>{{ customerObj.email }}</span>
                            </div>
                        </div>
                        <div class="data-item" v-if="customerObj.cell">
                            <svg class="data-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <div>
                                <strong>Teléfono:</strong>
                                <span>{{ customerObj.cell }}</span>
                            </div>
                        </div>
                        <div class="data-item" v-if="customerObj.career || customerObj.university">
                            <svg class="data-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 9 3 12 0v-5"></path></svg>
                            <div>
                                <strong>Carrera / Univ:</strong>
                                <span>{{ customerObj.career ? customerObj.career + ' - ' : '' }}{{ customerObj.university || '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-divider"></div>

                <!-- Column 2: Presentación -->
                <div class="info-col presentation-col">
                    <h3 class="section-title">PRESENTACIÓN</h3>
                    <p class="presentation-text">Estimados señores,</p>
                    <p class="presentation-text">
                        Agradecemos la oportunidad de presentar nuestra propuesta. En <strong>Avantage Group</strong> ofrecemos soluciones innovadoras y personalizadas que impulsan el crecimiento de su empresa.
                    </p>
                    <p class="presentation-text">Quedamos atentos a cualquier consulta.</p>
                    <div class="presentation-signature">
                        <p class="mb-0">Atentamente,</p>
                        <strong>Avantage Group</strong>
                    </div>
                </div>
            </section>

            <!-- Table Section -->
            <section class="table-section">
                <table class="quotation-table">
                    <thead>
                        <tr>
                            <th class="col-num text-center">N°</th>
                            <th class="col-desc">DESCRIPCIÓN</th>
                            <th class="col-detail">DETALLE</th>
                            <th class="col-qty text-center">CANT.</th>
                            <th class="col-price text-end">PRECIO UNIT.</th>
                            <th class="col-subtotal text-end">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(detail, idx) in mainDetails" :key="'main-' + idx">
                            <td class="col-num text-center">
                                <span class="num-badge">{{ String(idx + 1).padStart(2, '0') }}</span>
                            </td>
                            <td class="col-desc">
                                <div class="item-title-box">
                                    <div class="item-icon-box">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1D5EFF" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                                    </div>
                                    <strong>{{ detail.product ? (detail.product.name || detail.name) : (detail.name || 'Servicio / Producto') }}</strong>
                                </div>
                            </td>
                            <td class="col-detail">
                                <p class="detail-text">{{ detail.description }}</p>
                                <div v-if="detail.product_id == 58" class="detail-list mt-1">
                                    • 02 propuestas de tema<br>
                                    • Plan de tesis o proyecto de investigación<br>
                                    • Informe final de tesis o Tesis Final<br>
                                    • Orientación y/o asesoría extraordinaria en cualquier etapa de la tesis<br>
                                    • Plantilla de diapositivas<br>
                                    • Reporte de similitud TURNITIN<br>
                                    • E-book para la sustentación<br>
                                    • Balotario de preguntas<br>
                                    • Simulación de sustentación<br>
                                    • Levantamiento de observaciones
                                </div>
                            </td>
                            <td class="col-qty text-center">{{ detail.quantity || 1 }}</td>
                            <td class="col-price text-end">S/ {{ formatMoney(detail.price) }}</td>
                            <td class="col-subtotal text-end">S/ {{ formatMoney(detail.price * (detail.quantity || 1)) }}</td>
                        </tr>

                        <!-- Suggested Products section if exists -->
                        <template v-if="suggestedDetails.length > 0">
                            <tr class="section-divider-row">
                                <td colspan="6" class="suggested-header">PRODUCTO SUGERIDO</td>
                            </tr>
                            <tr v-for="(detail, idx) in suggestedDetails" :key="'sug-' + idx">
                                <td class="col-num text-center">
                                    <span class="num-badge">{{ String(mainDetails.length + idx + 1).padStart(2, '0') }}</span>
                                </td>
                                <td class="col-desc">
                                    <strong>{{ detail.product ? (detail.product.name || detail.product.title) : 'Producto Sugerido' }}</strong>
                                </td>
                                <td class="col-detail">
                                    <p class="detail-text">{{ detail.description }}</p>
                                </td>
                                <td class="col-qty text-center">{{ detail.quantity || 1 }}</td>
                                <td class="col-price text-end">S/ {{ formatMoney(detail.price) }}</td>
                                <td class="col-subtotal text-end">S/ {{ formatMoney(detail.price * (detail.quantity || 1)) }}</td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <!-- Summary & Observations Section -->
                <div class="summary-wrapper">
                    <div class="observations-box">
                        <h4 class="obs-title">OBSERVACIONES</h4>
                        <ul class="obs-list">
                            <li>Los precios incluyen IGV.</li>
                            <li>Se entrega garantía de 3 meses por cada servicio entregado.</li>
                            <li>Los tiempos de entrega pueden variar según el alcance del proyecto.</li>
                        </ul>
                    </div>

                    <div class="totals-box">
                        <div class="total-row">
                            <span class="total-label">SUBTOTAL</span>
                            <span class="total-value">S/ {{ formatMoney(subTotalProds) }}</span>
                        </div>
                        <div class="total-row" v-if="quotationObj.discount > 0">
                            <span class="total-label text-danger">DESCUENTO</span>
                            <span class="total-value text-danger">- S/ {{ formatMoney(quotationObj.discount) }}</span>
                        </div>
                        <div class="total-row">
                            <span class="total-label">IGV (18%)</span>
                            <span class="total-value">S/ {{ formatMoney(subTotalProds * 0.18) }}</span>
                        </div>
                        <div class="total-banner-blue">
                            <span class="banner-title">TOTAL</span>
                            <span class="banner-amount">S/ {{ formatMoney(quotationObj.amount) }}</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- 4 Features Grid Section -->
            <section class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon-circle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#111111" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <h5 class="feature-title">TIEMPO DE ENTREGA</h5>
                    <p class="feature-desc">{{ quotationObj.term || 'Según cronograma acordado con el cliente.' }}</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-circle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#111111" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2" ry="2"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                    </div>
                    <h5 class="feature-title">FORMA DE PAGO</h5>
                    <p class="feature-desc">50% de adelanto y 50% contra entrega del proyecto.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-circle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#111111" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><polyline points="9 12 11 14 15 10"></polyline></svg>
                    </div>
                    <h5 class="feature-title">GARANTÍA</h5>
                    <p class="feature-desc">3 meses por defectos de fabricación o desarrollo.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-circle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#111111" stroke-width="2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                    </div>
                    <h5 class="feature-title">VALIDEZ DE LA OFERTA</h5>
                    <p class="feature-desc">La presente cotización tiene validez hasta la fecha indicada.</p>
                </div>
            </section>

            <!-- Bottom Dark Footer -->
            <footer class="footer-band">
                <div class="footer-col">
                    <h6 class="footer-heading">DATOS DE LA EMPRESA</h6>
                    <ul class="footer-info-list">
                        <li>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                            <span>Avantage Group S.A.C.</span>
                        </li>
                        <li>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            <span>RUC: 20609876543</span>
                        </li>
                        <li>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>Prol. Cuzco 921 Huancayo / Miraflores, Lima</span>
                        </li>
                        <li>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span>+51 991 045 555</span>
                        </li>
                        <li>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <span>hola@avantagegroup.com</span>
                        </li>
                        <li>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                            <span>www.avantagegroup.com</span>
                        </li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h6 class="footer-heading">MÉTODOS DE PAGO</h6>
                    <div class="bank-list">
                        <div class="bank-item">
                            <span class="bank-badge">BCP</span>
                            <div class="bank-details">
                                <strong>Banco de Crédito del Perú</strong>
                                <small>Cuenta Corriente (S/): 193-12345657-0-12</small>
                            </div>
                        </div>
                        <div class="bank-item">
                            <span class="bank-badge">BBVA</span>
                            <div class="bank-details">
                                <strong>BBVA Perú</strong>
                                <small>Cuenta Corriente (S/): 0011-0245-0200156789</small>
                            </div>
                        </div>
                        <div class="bank-item">
                            <span class="bank-badge yape-badge">YAPE / PLIN</span>
                            <div class="bank-details">
                                <small>991 045 555</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="footer-col signature-col text-center">
                    <div class="signature-box">
                        <!-- Stylized Signature Graphic -->
                        <svg width="140" height="40" viewBox="0 0 200 60" fill="none" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round">
                            <path d="M10 40 Q30 10 50 35 T90 20 T130 45 T170 15 L190 35" />
                            <path d="M20 50 C 60 55, 120 48, 180 50" stroke="#1D5EFF" stroke-width="2" />
                        </svg>
                        <div class="sig-line"></div>
                        <strong class="sig-title">Firma Autorizada</strong>
                        <span class="sig-subtitle">Avantage Group</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            quotation: null
        }
    },
    methods: {
        getQuotationInfo() {
            axios.get(`/api/quotations/${this.$route.params.id}`)
                .then((res) => {
                    this.quotation = res.data
                })
                .catch(err => console.error(err))
        },
        print() {
            setTimeout(() => { window.print() }, 1000);
        },
        formatMoney(value) {
            if (value === undefined || value === null || isNaN(value)) return '0.00';
            return parseFloat(value).toLocaleString('es-PE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        }
    },
    mounted() {
        this.getQuotationInfo()
    },
    computed: {
        quotationObj() {
            if (!this.quotation) return null;
            if (Array.isArray(this.quotation)) {
                return this.quotation.length > 0 ? this.quotation[0] : null;
            }
            if (typeof this.quotation === 'object' && this.quotation.id) {
                return this.quotation;
            }
            return null;
        },
        customerObj() {
            const q = this.quotationObj;
            if (!q) return {};
            if (q.customers && Array.isArray(q.customers) && q.customers.length > 0) {
                return q.customers[0];
            }
            if (q.customer) {
                return q.customer;
            }
            return {};
        },
        mainDetails() {
            const q = this.quotationObj;
            if (!q || !q.details) return [];
            return q.details.filter(d => d.type == 1);
        },
        suggestedDetails() {
            const q = this.quotationObj;
            if (!q || !q.details) return [];
            return q.details.filter(d => d.type == 2);
        },
        subTotalProds() {
            if (this.mainDetails.length === 0) return 0;
            return this.mainDetails.reduce((acc, detail) => acc + (parseFloat(detail.price || 0) * (detail.quantity || 1)), 0);
        },
        subTotalProdsSugest() {
            if (this.suggestedDetails.length === 0) return 0;
            return this.suggestedDetails.reduce((acc, detail) => acc + (parseFloat(detail.price || 0) * (detail.quantity || 1)), 0);
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap');

* {
    font-family: 'Poppins', 'Montserrat', sans-serif !important;
    box-sizing: border-box;
}

.quotation-wrapper {
    background-color: #eef2f5;
    min-height: 100vh;
    padding: 2rem 0;
}

.page {
    width: 900px;
    background-color: #ffffff;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
    border-radius: 4px;
    overflow: hidden;
    color: #333333;
    position: relative;
}

/* Header Section */
.header-section {
    display: flex;
    justify-content: space-between;
    align-items: stretch;
    height: 145px;
    position: relative;
    background-color: #ffffff;
}

.header-left-polygon {
    width: 58%;
    background-color: #111111;
    clip-path: polygon(0 0, 100% 0, 82% 100%, 0 100%);
    display: flex;
    align-items: center;
    padding: 1.5rem 2.5rem;
    color: #ffffff;
}

.brand-content {
    display: flex;
    align-items: center;
    gap: 1.2rem;
}

.brand-title {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 1.7rem;
    font-weight: 900;
    color: #ffffff;
    letter-spacing: 2px;
    line-height: 1;
    margin: 0;
}

.group-tag {
    font-size: 0.65rem;
    letter-spacing: 4px;
    color: #BFC2C7;
    font-weight: 500;
}

.brand-services {
    font-size: 0.52rem;
    letter-spacing: 1.5px;
    color: #8E9499;
    margin-top: 5px;
    margin-bottom: 0;
    line-height: 1.3;
    font-weight: 600;
}

.header-right-info {
    width: 40%;
    padding: 1.2rem 2.5rem 1rem 0;
    text-align: right;
}

.doc-main-title {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 2.1rem;
    font-weight: 900;
    color: #111111;
    letter-spacing: 1.5px;
    margin: 0;
    line-height: 1;
}

.doc-code {
    font-size: 1.05rem;
    font-weight: 700;
    color: #1D5EFF;
    margin-top: 4px;
    margin-bottom: 12px;
}

.meta-list {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.76rem;
}

.meta-icon {
    color: #111111;
}

.meta-label {
    font-weight: 700;
    color: #111111;
    margin-right: 4px;
}

.meta-value {
    color: #555555;
}

/* Info Section (Client & Presentation) */
.info-section {
    display: flex;
    padding: 1.8rem 2.5rem 1.2rem 2.5rem;
    gap: 2rem;
}

.info-col {
    flex: 1;
}

.section-title {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 0.95rem;
    font-weight: 800;
    color: #1D5EFF;
    letter-spacing: 0.5px;
    margin-bottom: 1rem;
    text-transform: uppercase;
}

.info-divider {
    width: 1px;
    background-color: #E5E7EB;
    align-self: stretch;
}

.data-group {
    display: flex;
    flex-direction: column;
    gap: 0.55rem;
}

.data-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 0.82rem;
    color: #333333;
}

.data-icon {
    color: #111111;
    margin-top: 2px;
    flex-shrink: 0;
}

.data-item strong {
    color: #111111;
    margin-right: 4px;
}

.presentation-text {
    font-size: 0.8rem;
    color: #555555;
    line-height: 1.5;
    margin-bottom: 0.7rem;
}

.presentation-signature {
    margin-top: 1rem;
    font-size: 0.82rem;
    color: #111111;
}

/* Table Section */
.table-section {
    padding: 0 2.5rem 1.5rem 2.5rem;
}

.quotation-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #E5E7EB;
    font-size: 0.82rem;
}

.quotation-table thead {
    background-color: #111111;
    color: #ffffff;
}

.quotation-table th {
    padding: 0.75rem 0.8rem;
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 700;
    font-size: 0.78rem;
    letter-spacing: 0.5px;
}

.quotation-table td {
    padding: 0.8rem 0.8rem;
    border-bottom: 1px solid #E5E7EB;
    border-right: 1px solid #E5E7EB;
    vertical-align: top;
}

.quotation-table td:last-child {
    border-right: none;
}

.col-num { width: 6%; }
.col-desc { width: 26%; }
.col-detail { width: 42%; }
.col-qty { width: 7%; }
.col-price { width: 9.5%; }
.col-subtotal { width: 9.5%; }

.num-badge {
    font-weight: 800;
    color: #1D5EFF;
    font-size: 0.9rem;
}

.item-title-box {
    display: flex;
    align-items: center;
    gap: 8px;
}

.item-icon-box {
    width: 32px;
    height: 32px;
    background-color: rgba(29, 94, 255, 0.08);
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.detail-text {
    margin: 0;
    line-height: 1.4;
    white-space: pre-wrap;
    color: #555555;
}

.detail-list {
    margin-top: 6px;
    padding-left: 4px;
    font-size: 0.78rem;
    color: #666666;
    line-height: 1.5;
}

.suggested-header {
    background-color: rgba(29, 94, 255, 0.08);
    color: #1D5EFF;
    font-weight: 800;
    text-align: center;
    padding: 0.5rem;
    font-size: 0.8rem;
    letter-spacing: 1px;
}

/* Summary Wrapper */
.summary-wrapper {
    display: flex;
    justify-content: space-between;
    margin-top: 1rem;
    gap: 2rem;
}

.observations-box {
    flex: 1.3;
}

.obs-title {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 0.85rem;
    font-weight: 800;
    color: #1D5EFF;
    margin-bottom: 0.4rem;
}

.obs-list {
    padding-left: 1.2rem;
    margin: 0;
    font-size: 0.75rem;
    color: #666666;
    line-height: 1.5;
}

.totals-box {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.4rem;
}

.total-row {
    display: flex;
    justify-content: space-between;
    width: 100%;
    max-width: 260px;
    font-size: 0.85rem;
    font-weight: 700;
    color: #111111;
}

.total-banner-blue {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    max-width: 280px;
    background-color: #1D5EFF;
    color: #ffffff;
    padding: 0.7rem 1.2rem;
    border-radius: 4px;
    margin-top: 4px;
    box-shadow: 0 4px 12px rgba(29, 94, 255, 0.25);
}

.banner-title {
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 900;
    font-size: 1rem;
    letter-spacing: 1px;
}

.banner-amount {
    font-family: 'Montserrat', sans-serif !important;
    font-weight: 900;
    font-size: 1.15rem;
}

/* Features Grid */
.features-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    padding: 1rem 2.5rem 2rem 2.5rem;
}

.feature-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}

.feature-icon-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    border: 1.5px solid #111111;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
}

.feature-title {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 0.72rem;
    font-weight: 800;
    color: #1D5EFF;
    margin-bottom: 0.3rem;
    letter-spacing: 0.5px;
}

.feature-desc {
    font-size: 0.7rem;
    color: #666666;
    line-height: 1.3;
    margin: 0;
}

/* Bottom Dark Footer */
.footer-band {
    background-color: #111111;
    color: #ffffff;
    display: flex;
    justify-content: space-between;
    padding: 1.8rem 2.5rem;
    gap: 1.5rem;
}

.footer-col {
    flex: 1;
}

.footer-heading {
    font-family: 'Montserrat', sans-serif !important;
    font-size: 0.78rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: 0.5px;
    margin-bottom: 0.8rem;
}

.footer-info-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
    font-size: 0.72rem;
    color: #BFC2C7;
}

.footer-info-list li {
    display: flex;
    align-items: center;
    gap: 8px;
}

.bank-list {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
}

.bank-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.72rem;
}

.bank-badge {
    background-color: #ffffff;
    color: #111111;
    font-weight: 900;
    padding: 2px 6px;
    border-radius: 3px;
    font-size: 0.65rem;
}

.yape-badge {
    background-color: #1D5EFF;
    color: #ffffff;
}

.bank-details {
    display: flex;
    flex-direction: column;
    color: #BFC2C7;
}

.signature-box {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
}

.sig-line {
    width: 140px;
    height: 2px;
    background-color: #1D5EFF;
    margin: 6px 0;
}

.sig-title {
    font-size: 0.78rem;
    color: #ffffff;
}

.sig-subtitle {
    font-size: 0.68rem;
    color: #BFC2C7;
}

@media print {
    body {
        background: white !important;
    }
    .quotation-wrapper {
        padding: 0 !important;
        background: transparent !important;
    }
    .page {
        box-shadow: none !important;
        width: 100% !important;
    }
    .header-left-polygon, .total-banner-blue, .footer-band, .quotation-table thead {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}
</style>