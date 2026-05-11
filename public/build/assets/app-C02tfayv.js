var e={items:JSON.parse(localStorage.getItem(`verdant_cart`)||`[]`),save(){localStorage.setItem(`verdant_cart`,JSON.stringify(this.items)),this.updateBadge()},add(e){let t=this.items.find(t=>t.id===e.id);t?t.qty++:this.items.push({...e,qty:1}),this.save(),typeof notyf<`u`&&notyf.success(`Đã thêm "${e.name}" vào giỏ hàng!`)},remove(e){this.items=this.items.filter(t=>t.id!==e),this.save(),this.renderCart(),typeof this.renderCheckout==`function`&&this.renderCheckout(),typeof notyf<`u`&&notyf.success(`Đã xóa sản phẩm khỏi giỏ hàng`)},updateQty(e,t){let n=this.items.find(t=>t.id===e);n&&(n.qty=Math.max(1,n.qty+t),this.save(),this.renderCart(),typeof this.renderCheckout==`function`&&this.renderCheckout())},getTotal(){return this.items.reduce((e,t)=>e+t.price*t.qty,0)},getCount(){return this.items.reduce((e,t)=>e+t.qty,0)},formatPrice(e){return new Intl.NumberFormat(`vi-VN`).format(e)+` ₫`},updateBadge(){let e=document.getElementById(`cart-badge`);if(!e)return;let t=this.getCount();e.textContent=t,e.style.display=t>0?`flex`:`none`},renderCart(){let e=document.getElementById(`cart-items`),t=document.getElementById(`cart-summary`),n=document.getElementById(`cart-empty`),r=document.getElementById(`cart-count`);if(!e)return;if(this.items.length===0){e.innerHTML=``,n&&(n.style.display=`flex`),t&&(t.style.display=`none`),r&&(r.textContent=`0 sản phẩm`);return}n&&(n.style.display=`none`),t&&(t.style.display=`block`),r&&(r.textContent=this.items.length+` sản phẩm`),e.innerHTML=this.items.map(e=>`
            <div class="cart-item flex flex-col sm:flex-row gap-4 p-4 rounded-xl" style="background:#fff;border:1px solid #e1e3e1;" data-aos="fade-up">
                <div class="w-full sm:w-[140px] h-[160px] sm:h-[140px] rounded-lg overflow-hidden shrink-0" style="background:#eceeec;">
                    <img alt="${e.name}" class="w-full h-full object-cover" src="${e.img}"/>
                </div>
                <div class="flex flex-col justify-between flex-grow py-1">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <h3 class="font-semibold text-lg" style="color:#061b0e;font-family:'Noto Serif',serif;">${e.name}</h3>
                            <p class="text-sm mt-1" style="color:#72796f;">${e.variant||``}</p>
                        </div>
                        <button onclick="VerdantCart.confirmRemove('${e.id}','${e.name}')" class="p-1 rounded-full hover:bg-red-50 transition-colors" style="color:#72796f;">
                            <span class="material-symbols-outlined text-xl">close</span>
                        </button>
                    </div>
                    <div class="flex justify-between items-end mt-4 sm:mt-0">
                        <div class="flex items-center rounded-full" style="background:#eceeec;">
                            <button onclick="VerdantCart.updateQty('${e.id}',-1)" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-stone-300 transition-colors"><span class="material-symbols-outlined text-lg">remove</span></button>
                            <span class="w-8 text-center font-semibold text-sm" style="color:#061b0e;">${e.qty}</span>
                            <button onclick="VerdantCart.updateQty('${e.id}',1)" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-stone-300 transition-colors"><span class="material-symbols-outlined text-lg">add</span></button>
                        </div>
                        <span class="font-semibold text-lg" style="color:#061b0e;font-family:'Noto Serif',serif;">${this.formatPrice(e.price*e.qty)}</span>
                    </div>
                </div>
            </div>
        `).join(``);let i=document.getElementById(`cart-subtotal`),a=document.getElementById(`cart-total`);i&&(i.textContent=this.formatPrice(this.getTotal())),a&&(a.textContent=this.formatPrice(this.getTotal()))},renderCheckout(){let e=document.getElementById(`checkout-items`);if(!e)return;this.items.length===0?e.innerHTML=`<p class="text-on-surface-variant font-body-md py-4 text-center">Giỏ hàng của bạn đang trống.</p>`:e.innerHTML=this.items.map(e=>`
                <div class="flex items-center gap-md">
                    <div class="relative flex-shrink-0">
                        <div class="w-[72px] h-[90px] rounded bg-surface-container-highest overflow-hidden">
                            <img alt="${e.name}" class="w-full h-full object-cover" src="${e.img}"/>
                        </div>
                        <span class="absolute -top-2 -right-2 w-6 h-6 bg-secondary text-on-secondary rounded-full flex items-center justify-center font-label-sm text-[11px] font-bold shadow-sm">${e.qty}</span>
                    </div>
                    <div class="flex-grow flex flex-col">
                        <span class="font-label-md text-label-md text-primary">${e.name}</span>
                        <span class="font-body-md text-sm text-on-surface-variant">${e.variant||``}</span>
                        <div class="mt-2 flex items-center gap-3">
                            <div class="flex items-center rounded bg-surface-container-high overflow-hidden">
                                <button type="button" onclick="VerdantCart.updateQty('${e.id}',-1)" class="w-6 h-6 flex items-center justify-center hover:bg-surface-variant transition-colors text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">remove</span></button>
                                <span class="w-6 text-center font-label-sm text-label-sm text-on-surface">${e.qty}</span>
                                <button type="button" onclick="VerdantCart.updateQty('${e.id}',1)" class="w-6 h-6 flex items-center justify-center hover:bg-surface-variant transition-colors text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">add</span></button>
                            </div>
                            <button type="button" onclick="VerdantCart.confirmRemove('${e.id}', '${e.name}')" class="text-xs text-red-500 hover:underline">Xóa</button>
                        </div>
                    </div>
                    <span class="font-label-md text-label-md text-primary">${this.formatPrice(e.price*e.qty)}</span>
                </div>
            `).join(``);let t=this.getTotal(),n=0,r=document.querySelector(`input[name="shipping_method"]:checked`);r&&r.value===`express`&&(n=25e4);let i=0,a=``,o=document.getElementById(`checkout-discount-select`);o&&o.value!==`0`&&(i=parseInt(o.value)||0,a=o.options[o.selectedIndex].getAttribute(`data-name`));let s=document.getElementById(`checkout-subtotal`);s&&(s.textContent=this.formatPrice(t));let c=document.getElementById(`checkout-shipping-cost`);c&&(c.textContent=n===0?`Free`:this.formatPrice(n));let l=document.getElementById(`checkout-discount-row`);l&&(i>0?(l.style.display=`flex`,document.getElementById(`checkout-discount-name`).textContent=a,document.getElementById(`checkout-discount-amount`).textContent=`-`+this.formatPrice(i)):l.style.display=`none`);let u=Math.max(0,t+n-i);document.querySelectorAll(`.checkout-total-price`).forEach(e=>e.textContent=this.formatPrice(u))},async processPayment(e){if(e&&e.preventDefault(),this.items.length===0){typeof notyf<`u`&&notyf.error(`Giỏ hàng của bạn đang trống!`);return}let t=document.getElementById(`firstName`)?.value||``,n=document.getElementById(`lastName`)?.value||``,r=document.getElementById(`email`)?.value||``,i=document.getElementById(`phone`)?.value||``,a=document.getElementById(`address`)?.value||``,o=document.getElementById(`city`)?.value||``,s=(t+` `+n).trim()||`Khách hàng`,c=a+(o?`, `+o:``)||`Chưa cung cấp`,l=[{id:`email`,label:`Email`},{id:`firstName`,label:`Họ`},{id:`lastName`,label:`Tên`},{id:`address`,label:`Địa chỉ`},{id:`city`,label:`Thành phố`},{id:`phone`,label:`Số điện thoại`}],u=[];if(l.forEach(e=>{let t=document.getElementById(e.id);if(t){t.classList.remove(`!border-red-500`,`!bg-red-50`,`!ring-red-200`);let e=t.parentElement.querySelector(`.field-error-msg`);e&&e.remove()}}),l.forEach(e=>{let t=document.getElementById(e.id);if(t&&!t.value.trim()){u.push(e.label),t.classList.add(`!border-red-500`,`!bg-red-50`,`!ring-red-200`);let n=document.createElement(`span`);n.className=`field-error-msg text-red-500 text-xs font-semibold mt-1 block`,n.textContent=`⚠ ${e.label} không được để trống`,t.parentElement.appendChild(n),t.addEventListener(`input`,function e(){t.classList.remove(`!border-red-500`,`!bg-red-50`,`!ring-red-200`);let n=t.parentElement.querySelector(`.field-error-msg`);n&&n.remove(),t.removeEventListener(`input`,e)})}}),u.length>0){typeof notyf<`u`&&notyf.error(`Vui lòng điền: ${u.join(`, `)}`);let e=document.getElementById(l.find(e=>!document.getElementById(e.id)?.value.trim())?.id);e&&e.scrollIntoView({behavior:`smooth`,block:`center`}),e?.focus();return}let d=this.getTotal(),f=0,p=document.querySelector(`input[name="shipping_method"]:checked`);p&&p.value===`express`&&(f=25e4);let m=0,h=``,g=null,_=document.getElementById(`checkout-discount-select`);_&&_.value!==`0`&&(m=parseInt(_.value)||0,h=_.options[_.selectedIndex].getAttribute(`data-name`),h===`GIFT50K`&&(g=1),h===`GIFT100K`&&(g=2),h===`VIP200K`&&(g=3));let v=Math.max(0,d+f-m);try{let e=document.querySelector(`meta[name="csrf-token"]`).getAttribute(`content`),t=await fetch(`/api/orders`,{method:`POST`,headers:{"Content-Type":`application/json`,"X-CSRF-TOKEN":e,Accept:`application/json`},body:JSON.stringify({customer_name:s,customer_email:r,customer_phone:i,shipping_address:c,total_amount:v,gift_code_id:g,discount_amount:m,items:this.items.map(e=>({plant_slug:e.id,plant_name:e.name,price:e.price,quantity:e.qty}))})}),n=await t.json();if(!t.ok)throw Error(n.message||`Lỗi khi tạo đơn hàng`);let a=this.items.map(e=>`
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; border-bottom:1px dashed #e1e3e1; padding-bottom:8px;">
                    <div style="text-align:left;">
                        <div style="font-weight:600; color:#061b0e; font-size:14px;">${e.name}</div>
                        <div style="font-size:12px; color:#72796f;">SL: ${e.qty} x ${this.formatPrice(e.price)}</div>
                    </div>
                    <div style="font-weight:600; color:#061b0e; font-size:14px;">${this.formatPrice(e.price*e.qty)}</div>
                </div>
            `).join(``),o=`
                <div style="font-family:'Inter', sans-serif; text-align:left; padding:10px;">
                    <h3 style="text-align:center; font-family:'Playfair Display', serif; font-size:24px; color:#061b0e; margin-bottom:5px;">HÓA ĐƠN MUA HÀNG</h3>
                    <p style="text-align:center; font-size:13px; color:#72796f; margin-bottom:20px;">Mã đơn: ${n.order_number}</p>
                    
                    <div style="background:#f8faf8; padding:15px; border-radius:8px; margin-bottom:20px; font-size:14px; border:1px solid #e1e3e1;">
                        <div style="margin-bottom:5px;"><strong>Khách hàng:</strong> ${s}</div>
                        <div><strong>Địa chỉ giao hàng:</strong> ${c}</div>
                    </div>

                    <div style="margin-bottom:20px;">
                        ${a}
                    </div>

                    <div style="display:flex; justify-content:space-between; margin-bottom:5px; font-size:14px; color:#434843;">
                        <span>Tạm tính:</span>
                        <span>${this.formatPrice(d)}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:5px; font-size:14px; color:#434843;">
                        <span>Phí giao hàng:</span>
                        <span>${f===0?`Miễn phí`:this.formatPrice(f)}</span>
                    </div>
                    ${m>0?`
                    <div style="display:flex; justify-content:space-between; margin-bottom:15px; font-size:14px; color:#061b0e; border-bottom:2px solid #061b0e; padding-bottom:15px; font-weight: 600;">
                        <span>Giảm giá (${h}):</span>
                        <span>-${this.formatPrice(m)}</span>
                    </div>
                    `:`
                    <div style="border-bottom:2px solid #061b0e; margin-bottom:15px; margin-top: 10px;"></div>
                    `}
                    <div style="display:flex; justify-content:space-between; font-size:18px; font-weight:700; color:#061b0e;">
                        <span>Tổng thanh toán:</span>
                        <span>${this.formatPrice(v)}</span>
                    </div>
                </div>
            `;typeof Swal<`u`?Swal.fire({html:o,showCloseButton:!0,showCancelButton:!0,focusConfirm:!1,confirmButtonText:`Đóng`,showCancelButton:!1,confirmButtonColor:`#061b0e`,customClass:{cancelButton:`!text-stone-800`},width:`500px`}).then(e=>{this.items=[],this.save(),this.renderCheckout(),window.location.href=`/category`}):(alert(`Đặt hàng thành công!`),this.items=[],this.save(),window.location.href=`/category`)}catch(e){console.error(`Order error:`,e),typeof notyf<`u`&&notyf.error(`Có lỗi xảy ra: `+e.message)}},confirmRemove(e,t){typeof Swal<`u`?Swal.fire({title:`Xóa sản phẩm?`,text:`Bạn muốn xóa "${t}" khỏi giỏ hàng?`,icon:`warning`,showCancelButton:!0,confirmButtonColor:`#ba1a1a`,cancelButtonColor:`#72796f`,confirmButtonText:`Xóa`,cancelButtonText:`Hủy`}).then(t=>{t.isConfirmed&&this.remove(e)}):confirm(`Xóa "${t}" khỏi giỏ hàng?`)&&this.remove(e)}},t={allProducts:window.INITIAL_PRODUCTS||[],formatPrice(e){return new Intl.NumberFormat(`vi-VN`).format(e)+` ₫`},search(e){if(!e||e.trim()===``)return this.allProducts;let t=e.toLowerCase();return this.allProducts.filter(e=>e.name.toLowerCase().includes(t)||e.vn.toLowerCase().includes(t)||e.tag&&e.tag.toLowerCase().includes(t))},sort(e,t){let n=[...e];switch(t){case`price-asc`:n.sort((e,t)=>e.price-t.price);break;case`price-desc`:n.sort((e,t)=>t.price-e.price);break;case`name`:n.sort((e,t)=>e.name.localeCompare(t.name));break;default:break}return n},renderResults(e,t){let n=document.getElementById(t);if(!n)return;let r=document.getElementById(`search-count`);r&&(r.textContent=e.length),n.innerHTML=e.map((e,t)=>`
            <article class="group flex flex-col cursor-pointer" data-aos="fade-up" data-aos-delay="${t*80}">
                <a href="/product?id=${e.id}" class="block">
                    <div class="relative w-full aspect-[4/5] overflow-hidden rounded-xl mb-3" style="background:#eceeec;">
                        <img alt="${e.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="${e.img}"/>
                        ${e.tag?`<div class="absolute top-3 left-3"><span class="px-3 py-1.5 rounded-full text-xs font-semibold" style="background:rgba(180,205,184,0.9);color:#061b0e;">${e.tag}</span></div>`:``}
                    </div>
                </a>
                <div class="flex flex-col flex-grow">
                    <h2 class="font-semibold text-base mb-0.5" style="color:#061b0e;font-family:'Noto Serif',serif;">${e.name}</h2>
                    <p class="text-sm mb-2" style="color:#72796f;">${e.vn}</p>
                    <div class="flex items-center justify-between mt-auto pt-2">
                        <span class="font-semibold" style="color:#291100;">${this.formatPrice(e.price)}</span>
                        <button onclick="event.preventDefault(); event.stopPropagation(); VerdantCart.add({id:'${e.id}',name:'${e.name}',price:${e.price},img:'${e.img}',variant:'${e.vn}'})" class="text-sm font-semibold px-3 py-1.5 rounded-full transition-all hover:scale-105" style="background:#061b0e;color:#fff;">Thêm vào giỏ</button>
                    </div>
                </div>
            </article>
        `).join(``),typeof AOS<`u`&&AOS.refresh()}},n={render(){let e=document.getElementById(`product-detail-container`);if(!e)return;let n=new URLSearchParams(window.location.search).get(`id`)||`ficus-lyrata`,r=t.allProducts.find(e=>e.id===n);if(!r&&t.allProducts.length>0)r=t.allProducts[0];else if(!r)return;let i=`Cây cảnh`;r.cat===`desk`&&(i=`Cây Để Bàn`),r.cat===`hanging`&&(i=`Cây Dây Leo`),r.cat===`large`&&(i=`Cây Trồng Sàn`);let a=`Ánh sáng trung bình`,o=`Đặt cây gần cửa sổ có nắng, nhưng tránh ánh nắng gắt vào buổi chiều để không làm cháy lá.`;r.light===`low`?(a=`Ánh sáng yếu đến trung bình`,o=`Phát triển tốt trong điều kiện ánh sáng yếu. Tránh ánh nắng mặt trời trực tiếp.`):r.light===`high`&&(a=`Ánh sáng mạnh, gián tiếp`,o=`Cần nhiều ánh sáng tự nhiên, gián tiếp để phát triển tốt nhất.`),e.innerHTML=`
        <!-- Product Image -->
        <div class="flex flex-col gap-8">
            <div class="w-full bg-surface-container-low rounded-lg overflow-hidden aspect-[4/5] relative">
                <img alt="${r.name}" class="w-full h-full object-cover" src="${r.img}"/>
                ${r.tag?`<div class="absolute top-4 left-4"><span class="px-4 py-2 rounded-full text-sm font-semibold shadow-md" style="background:rgba(255,255,255,0.9);color:#061b0e;">${r.tag}</span></div>`:``}
            </div>
        </div>
        <!-- Product Info -->
        <div class="flex flex-col justify-start">
            <!-- Breadcrumbs -->
            <nav class="flex gap-2 text-surface-tint font-label-sm text-sm mb-6">
                <a class="hover:underline" href="/category">Danh mục</a>
                <span>/</span>
                <a class="hover:underline" href="/category?cat=${r.cat}">${i}</a>
            </nav>
            <!-- Title & Price -->
            <h1 class="font-display-lg text-4xl lg:text-5xl text-on-background mb-3" style="font-family: 'Playfair Display', serif; color: #061b0e;">${r.vn}</h1>
            <p class="font-headline-md text-2xl text-primary mb-6" style="font-weight: 600;">${t.formatPrice(r.price)}</p>
            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mb-6">
                <span class="bg-surface-container px-3 py-1 rounded-full font-label-sm text-xs text-on-surface-variant">${r.name}</span>
                <span class="bg-surface-container px-3 py-1 rounded-full font-label-sm text-xs text-on-surface-variant">${a}</span>
            </div>
            <!-- Description -->
            <p class="font-body-lg text-base text-on-surface-variant mb-10 max-w-prose leading-relaxed">
                Đẹp mắt và tràn đầy sức sống, cây <strong>${r.vn}</strong> (${r.name}) mang đến một mảng xanh thiên nhiên cho không gian trong nhà. ${r.tag?`Nổi bật với đặc tính `+r.tag.toLowerCase()+`, đây`:`Đây`} là một điểm nhấn hoàn hảo cho bất kỳ căn phòng nào, và cần điều kiện ${a.toLowerCase()} để phát triển tốt nhất.
            </p>
            <!-- Actions -->
            <div class="flex flex-col gap-4 mb-10 border-b border-surface-variant pb-8">
                <button onclick="event.preventDefault(); VerdantCart.add({id:'${r.id}',name:'${r.name}',price:${r.price},img:'${r.img}',variant:'${r.vn}'})" class="bg-[#061b0e] text-white font-label-md text-base py-4 px-8 rounded-full hover:bg-opacity-90 transition-colors w-full md:w-auto text-center font-semibold shadow-md">
                    Thêm vào giỏ hàng
                </button>
                <p class="font-label-sm text-sm text-surface-tint text-center md:text-left mt-2">
                    Giao hàng toàn quốc trong 3-5 ngày làm việc.
                </p>
            </div>
            <!-- Care Guide -->
            <div class="flex flex-col gap-6">
                <h2 class="font-headline-sm text-2xl text-on-background mb-2" style="font-family: 'Noto Serif', serif; color: #061b0e;">Hướng dẫn chăm sóc</h2>
                <div class="flex items-start gap-4">
                    <span class="material-symbols-outlined text-tertiary mt-1">light_mode</span>
                    <div>
                        <h3 class="font-label-md text-base font-semibold text-on-background">${a}</h3>
                        <p class="font-body-md text-sm text-on-surface-variant mt-1">${o}</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 mt-2">
                    <span class="material-symbols-outlined text-secondary mt-1">water_drop</span>
                    <div>
                        <h3 class="font-label-md text-base font-semibold text-on-background">Tưới nước vừa phải</h3>
                        <p class="font-body-md text-sm text-on-surface-variant mt-1">Tưới khi lớp đất trên bề mặt (khoảng 5cm) đã khô. Đảm bảo chậu có lỗ thoát nước để tránh thối rễ.</p>
                    </div>
                </div>
            </div>
        </div>
        `}},r={products:t.allProducts,currentSort:`popular`,activeFilters:{cat:[],light:[]},init(){let e=document.getElementById(`category-sort`);e&&e.addEventListener(`change`,e=>{this.currentSort=e.target.value,this.applyFilters()}),document.querySelectorAll(`.filter-checkbox`).forEach(e=>{e.addEventListener(`change`,()=>this.applyFilters())}),this.applyFilters()},applyFilters(){let e=[...this.products],n=[...document.querySelectorAll(`.filter-cat:checked`)].map(e=>e.value),r=[...document.querySelectorAll(`.filter-light:checked`)].map(e=>e.value),i=[...document.querySelectorAll(`.filter-tag:checked`)].map(e=>e.value);n.length&&(e=e.filter(e=>n.includes(e.cat))),r.length&&(e=e.filter(e=>r.includes(e.light))),i.length&&(e=e.filter(e=>e.tag?i.some(t=>t===`Lọc khí`?e.tag.includes(`Lọc không khí`)||e.tag.includes(`Lọc khí`):e.tag.includes(t)):!1)),e=t.sort(e,this.currentSort),this.render(e)},render(e){let n=document.getElementById(`category-grid`);if(!n)return;let r=document.getElementById(`category-count`);r&&(r.textContent=`Showing ${e.length} plants`),n.innerHTML=e.map((e,n)=>`
            <a href="/product?id=${e.id}" class="group cursor-pointer block" data-aos="fade-up" data-aos-delay="${n*60}">
                <div class="relative rounded-xl overflow-hidden aspect-[4/5] mb-3" style="background:#eceeec;">
                    <img alt="${e.name}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="${e.img}"/>
                    ${e.tag?`<div class="absolute top-3 left-3"><span class="px-3 py-1.5 rounded-full text-xs font-semibold" style="background:rgba(180,205,184,0.9);color:#061b0e;">${e.tag}</span></div>`:``}
                    <button onclick="event.preventDefault(); event.stopPropagation(); VerdantCart.add({id:'${e.id}',name:'${e.name}',price:${e.price},img:'${e.img}',variant:'${e.vn}'})" class="absolute bottom-3 right-3 w-11 h-11 rounded-full flex items-center justify-center opacity-0 translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 shadow-lg" style="background:#061b0e;color:#fff;">
                        <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                    </button>
                </div>
                <h2 class="font-semibold" style="color:#061b0e;font-family:'Noto Serif',serif;">${e.name}</h2>
                <p class="text-sm mt-0.5" style="color:#72796f;">${t.formatPrice(e.price)}</p>
            </a>
        `).join(``),typeof AOS<`u`&&AOS.refresh()}};window.VerdantCart=e,window.VerdantSearch=t,window.VerdantCategory=r,document.addEventListener(`DOMContentLoaded`,()=>{e.updateBadge(),document.getElementById(`cart-items`)&&e.renderCart(),document.getElementById(`checkout-items`)&&e.renderCheckout(),document.getElementById(`category-grid`)&&r.init(),document.getElementById(`product-detail-container`)&&n.render();let i=document.getElementById(`search-input`);if(i){let e,n=()=>{let e=i.value,n=t.search(e);t.renderResults(n,`search-results`)};i.addEventListener(`input`,()=>{clearTimeout(e),e=setTimeout(n,300)}),n()}let a=document.getElementById(`search-sort`);a&&a.addEventListener(`change`,()=>{let e=document.getElementById(`search-input`)?.value||``,n=t.search(e);n=t.sort(n,a.value),t.renderResults(n,`search-results`)}),typeof VanillaTilt<`u`&&VanillaTilt.init(document.querySelectorAll(`.tilt-card`),{max:8,speed:400,glare:!0,"max-glare":.15}),typeof gsap<`u`&&document.querySelector(`.hero-title`)&&(gsap.from(`.hero-title`,{y:60,opacity:0,duration:1.2,ease:`power3.out`}),gsap.from(`.hero-subtitle`,{y:40,opacity:0,duration:1,delay:.3,ease:`power3.out`}),gsap.from(`.hero-cta`,{y:30,opacity:0,duration:.8,delay:.6,ease:`power3.out`})),typeof ScrollReveal<`u`&&ScrollReveal().reveal(`.sr-reveal`,{distance:`30px`,duration:800,easing:`ease-out`,origin:`bottom`,interval:100});let o=document.querySelector(`meta[name="flash-success"]`);o&&o.content&&typeof notyf<`u`&&notyf.success(o.content)}),window.addEventListener(`pageshow`,e=>{e.persisted&&window.location.pathname.includes(`/category`)&&setTimeout(()=>{window.VerdantCategory&&r.applyFilters()},10)});