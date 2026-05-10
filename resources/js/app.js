// ========== VERDANT BOTANICAL BOUTIQUE - Main JS ==========

// ===== CART MANAGEMENT =====
const VerdantCart = {
    items: JSON.parse(localStorage.getItem('verdant_cart') || '[]'),

    save() { localStorage.setItem('verdant_cart', JSON.stringify(this.items)); this.updateBadge(); },

    add(product) {
        const existing = this.items.find(i => i.id === product.id);
        if (existing) { existing.qty++; } else { this.items.push({ ...product, qty: 1 }); }
        this.save();
        if (typeof notyf !== 'undefined') notyf.success(`Đã thêm "${product.name}" vào giỏ hàng!`);
    },

    remove(id) {
        this.items = this.items.filter(i => i.id !== id);
        this.save();
        this.renderCart();
        if (typeof this.renderCheckout === 'function') this.renderCheckout();
        if (typeof notyf !== 'undefined') notyf.success('Đã xóa sản phẩm khỏi giỏ hàng');
    },

    updateQty(id, delta) {
        const item = this.items.find(i => i.id === id);
        if (!item) return;
        item.qty = Math.max(1, item.qty + delta);
        this.save();
        this.renderCart();
        if (typeof this.renderCheckout === 'function') this.renderCheckout();
    },

    getTotal() { return this.items.reduce((sum, i) => sum + i.price * i.qty, 0); },
    getCount() { return this.items.reduce((sum, i) => sum + i.qty, 0); },

    formatPrice(n) { return new Intl.NumberFormat('vi-VN').format(n) + ' ₫'; },

    updateBadge() {
        const badge = document.getElementById('cart-badge');
        if (!badge) return;
        const count = this.getCount();
        badge.textContent = count;
        badge.style.display = count > 0 ? 'flex' : 'none';
    },

    renderCart() {
        const container = document.getElementById('cart-items');
        const summaryEl = document.getElementById('cart-summary');
        const emptyEl = document.getElementById('cart-empty');
        const countEl = document.getElementById('cart-count');
        if (!container) return;

        if (this.items.length === 0) {
            container.innerHTML = '';
            if (emptyEl) emptyEl.style.display = 'flex';
            if (summaryEl) summaryEl.style.display = 'none';
            if (countEl) countEl.textContent = '0 sản phẩm';
            return;
        }
        if (emptyEl) emptyEl.style.display = 'none';
        if (summaryEl) summaryEl.style.display = 'block';
        if (countEl) countEl.textContent = this.items.length + ' sản phẩm';

        container.innerHTML = this.items.map(item => `
            <div class="cart-item flex flex-col sm:flex-row gap-4 p-4 rounded-xl" style="background:#fff;border:1px solid #e1e3e1;" data-aos="fade-up">
                <div class="w-full sm:w-[140px] h-[160px] sm:h-[140px] rounded-lg overflow-hidden shrink-0" style="background:#eceeec;">
                    <img alt="${item.name}" class="w-full h-full object-cover" src="${item.img}"/>
                </div>
                <div class="flex flex-col justify-between flex-grow py-1">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <h3 class="font-semibold text-lg" style="color:#061b0e;font-family:'Noto Serif',serif;">${item.name}</h3>
                            <p class="text-sm mt-1" style="color:#72796f;">${item.variant || ''}</p>
                        </div>
                        <button onclick="VerdantCart.confirmRemove('${item.id}','${item.name}')" class="p-1 rounded-full hover:bg-red-50 transition-colors" style="color:#72796f;">
                            <span class="material-symbols-outlined text-xl">close</span>
                        </button>
                    </div>
                    <div class="flex justify-between items-end mt-4 sm:mt-0">
                        <div class="flex items-center rounded-full" style="background:#eceeec;">
                            <button onclick="VerdantCart.updateQty('${item.id}',-1)" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-stone-300 transition-colors"><span class="material-symbols-outlined text-lg">remove</span></button>
                            <span class="w-8 text-center font-semibold text-sm" style="color:#061b0e;">${item.qty}</span>
                            <button onclick="VerdantCart.updateQty('${item.id}',1)" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-stone-300 transition-colors"><span class="material-symbols-outlined text-lg">add</span></button>
                        </div>
                        <span class="font-semibold text-lg" style="color:#061b0e;font-family:'Noto Serif',serif;">${this.formatPrice(item.price * item.qty)}</span>
                    </div>
                </div>
            </div>
        `).join('');

        // Update summary
        const subtotalEl = document.getElementById('cart-subtotal');
        const totalEl = document.getElementById('cart-total');
        if (subtotalEl) subtotalEl.textContent = this.formatPrice(this.getTotal());
        if (totalEl) totalEl.textContent = this.formatPrice(this.getTotal());
    },

    renderCheckout() {
        const container = document.getElementById('checkout-items');
        if (!container) return;
        
        if (this.items.length === 0) {
            container.innerHTML = `<p class="text-on-surface-variant font-body-md py-4 text-center">Giỏ hàng của bạn đang trống.</p>`;
        } else {
            container.innerHTML = this.items.map(item => `
                <div class="flex items-center gap-md">
                    <div class="relative flex-shrink-0">
                        <div class="w-[72px] h-[90px] rounded bg-surface-container-highest overflow-hidden">
                            <img alt="${item.name}" class="w-full h-full object-cover" src="${item.img}"/>
                        </div>
                        <span class="absolute -top-2 -right-2 w-6 h-6 bg-secondary text-on-secondary rounded-full flex items-center justify-center font-label-sm text-[11px] font-bold shadow-sm">${item.qty}</span>
                    </div>
                    <div class="flex-grow flex flex-col">
                        <span class="font-label-md text-label-md text-primary">${item.name}</span>
                        <span class="font-body-md text-sm text-on-surface-variant">${item.variant || ''}</span>
                        <div class="mt-2 flex items-center gap-3">
                            <div class="flex items-center rounded bg-surface-container-high overflow-hidden">
                                <button type="button" onclick="VerdantCart.updateQty('${item.id}',-1)" class="w-6 h-6 flex items-center justify-center hover:bg-surface-variant transition-colors text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">remove</span></button>
                                <span class="w-6 text-center font-label-sm text-label-sm text-on-surface">${item.qty}</span>
                                <button type="button" onclick="VerdantCart.updateQty('${item.id}',1)" class="w-6 h-6 flex items-center justify-center hover:bg-surface-variant transition-colors text-on-surface-variant"><span class="material-symbols-outlined text-[14px]">add</span></button>
                            </div>
                            <button type="button" onclick="VerdantCart.confirmRemove('${item.id}', '${item.name}')" class="text-xs text-red-500 hover:underline">Xóa</button>
                        </div>
                    </div>
                    <span class="font-label-md text-label-md text-primary">${this.formatPrice(item.price * item.qty)}</span>
                </div>
            `).join('');
        }

        // Update totals
        let subtotal = this.getTotal();
        let shipping = 0; // Default Free
        const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
        if (shippingMethod && shippingMethod.value === 'express') {
            shipping = 250000;
        }

        let discount = 0;
        let discountName = '';
        const discountSelect = document.getElementById('checkout-discount-select');
        if (discountSelect && discountSelect.value !== '0') {
            discount = parseInt(discountSelect.value) || 0;
            const selectedOption = discountSelect.options[discountSelect.selectedIndex];
            discountName = selectedOption.getAttribute('data-name');
        }

        const subtotalEl = document.getElementById('checkout-subtotal');
        if (subtotalEl) subtotalEl.textContent = this.formatPrice(subtotal);

        const shippingEl = document.getElementById('checkout-shipping-cost');
        if (shippingEl) shippingEl.textContent = shipping === 0 ? 'Free' : this.formatPrice(shipping);

        const discountRow = document.getElementById('checkout-discount-row');
        if (discountRow) {
            if (discount > 0) {
                discountRow.style.display = 'flex';
                document.getElementById('checkout-discount-name').textContent = discountName;
                document.getElementById('checkout-discount-amount').textContent = '-' + this.formatPrice(discount);
            } else {
                discountRow.style.display = 'none';
            }
        }

        const total = Math.max(0, subtotal + shipping - discount);
        const totalEls = document.querySelectorAll('.checkout-total-price');
        totalEls.forEach(el => el.textContent = this.formatPrice(total));
    },

    async processPayment(e) {
        if (e) e.preventDefault();
        if (this.items.length === 0) {
            if (typeof notyf !== 'undefined') notyf.error('Giỏ hàng của bạn đang trống!');
            return;
        }

        // Lấy thông tin khách hàng (nếu có)
        const firstName = document.getElementById('firstName')?.value || '';
        const lastName = document.getElementById('lastName')?.value || '';
        const email = document.getElementById('email')?.value || '';
        const phone = document.getElementById('phone')?.value || '';
        const addressInput = document.getElementById('address')?.value || '';
        const city = document.getElementById('city')?.value || '';
        const fullName = (firstName + ' ' + lastName).trim() || 'Khách hàng';
        const finalAddress = (addressInput + (city ? ', ' + city : '')) || 'Chưa cung cấp';
        
        // Validate required fields
        if (!email || !firstName || !addressInput) {
            if (typeof notyf !== 'undefined') notyf.error('Vui lòng điền đầy đủ thông tin giao hàng!');
            return;
        }

        let subtotal = this.getTotal();
        let shipping = 0;
        const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
        if (shippingMethod && shippingMethod.value === 'express') {
            shipping = 250000;
        }
        
        let discount = 0;
        let discountName = '';
        let discountCodeId = null;
        const discountSelect = document.getElementById('checkout-discount-select');
        if (discountSelect && discountSelect.value !== '0') {
            discount = parseInt(discountSelect.value) || 0;
            const selectedOption = discountSelect.options[discountSelect.selectedIndex];
            discountName = selectedOption.getAttribute('data-name');
            // Mock map discount name to ID (in a real app, options would have value=id)
            if (discountName === 'GIFT50K') discountCodeId = 1;
            if (discountName === 'GIFT100K') discountCodeId = 2;
            if (discountName === 'VIP200K') discountCodeId = 3;
        }
        
        let total = Math.max(0, subtotal + shipping - discount);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/api/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    customer_name: fullName,
                    customer_email: email,
                    customer_phone: phone,
                    shipping_address: finalAddress,
                    total_amount: total,
                    gift_code_id: discountCodeId,
                    discount_amount: discount,
                    items: this.items.map(i => ({
                        plant_slug: i.id,
                        plant_name: i.name,
                        price: i.price,
                        quantity: i.qty
                    }))
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Lỗi khi tạo đơn hàng');
            }

            // Tạo HTML cho hóa đơn
            let itemsHtml = this.items.map(i => `
                <div style="display:flex; justify-content:space-between; margin-bottom:8px; border-bottom:1px dashed #e1e3e1; padding-bottom:8px;">
                    <div style="text-align:left;">
                        <div style="font-weight:600; color:#061b0e; font-size:14px;">${i.name}</div>
                        <div style="font-size:12px; color:#72796f;">SL: ${i.qty} x ${this.formatPrice(i.price)}</div>
                    </div>
                    <div style="font-weight:600; color:#061b0e; font-size:14px;">${this.formatPrice(i.price * i.qty)}</div>
                </div>
            `).join('');

            let invoiceHtml = `
                <div style="font-family:'Inter', sans-serif; text-align:left; padding:10px;">
                    <h3 style="text-align:center; font-family:'Playfair Display', serif; font-size:24px; color:#061b0e; margin-bottom:5px;">HÓA ĐƠN MUA HÀNG</h3>
                    <p style="text-align:center; font-size:13px; color:#72796f; margin-bottom:20px;">Mã đơn: ${data.order_number}</p>
                    
                    <div style="background:#f8faf8; padding:15px; border-radius:8px; margin-bottom:20px; font-size:14px; border:1px solid #e1e3e1;">
                        <div style="margin-bottom:5px;"><strong>Khách hàng:</strong> ${fullName}</div>
                        <div><strong>Địa chỉ giao hàng:</strong> ${finalAddress}</div>
                    </div>

                    <div style="margin-bottom:20px;">
                        ${itemsHtml}
                    </div>

                    <div style="display:flex; justify-content:space-between; margin-bottom:5px; font-size:14px; color:#434843;">
                        <span>Tạm tính:</span>
                        <span>${this.formatPrice(subtotal)}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:5px; font-size:14px; color:#434843;">
                        <span>Phí giao hàng:</span>
                        <span>${shipping === 0 ? 'Miễn phí' : this.formatPrice(shipping)}</span>
                    </div>
                    ${discount > 0 ? `
                    <div style="display:flex; justify-content:space-between; margin-bottom:15px; font-size:14px; color:#061b0e; border-bottom:2px solid #061b0e; padding-bottom:15px; font-weight: 600;">
                        <span>Giảm giá (${discountName}):</span>
                        <span>-${this.formatPrice(discount)}</span>
                    </div>
                    ` : `
                    <div style="border-bottom:2px solid #061b0e; margin-bottom:15px; margin-top: 10px;"></div>
                    `}
                    <div style="display:flex; justify-content:space-between; font-size:18px; font-weight:700; color:#061b0e;">
                        <span>Tổng thanh toán:</span>
                        <span>${this.formatPrice(total)}</span>
                    </div>
                </div>
            `;

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    html: invoiceHtml,
                    showCloseButton: true,
                    showCancelButton: true,
                    focusConfirm: false,
                    confirmButtonText: 'Đóng',
                    showCancelButton: false,
                    confirmButtonColor: '#061b0e',
                    customClass: {
                        cancelButton: '!text-stone-800'
                    },
                    width: '500px'
                }).then((result) => {
                    this.items = [];
                    this.save();
                    this.renderCheckout();
                    window.location.href = '/category'; // Quay về trang danh mục
                });
            } else {
                alert('Đặt hàng thành công!');
                this.items = [];
                this.save();
                window.location.href = '/category';
            }
        } catch (err) {
            console.error('Order error:', err);
            if (typeof notyf !== 'undefined') notyf.error('Có lỗi xảy ra: ' + err.message);
        }
    },

    confirmRemove(id, name) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Xóa sản phẩm?',
                text: `Bạn muốn xóa "${name}" khỏi giỏ hàng?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ba1a1a',
                cancelButtonColor: '#72796f',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then(r => { if (r.isConfirmed) this.remove(id); });
        } else {
            if (confirm(`Xóa "${name}" khỏi giỏ hàng?`)) this.remove(id);
        }
    }
};

// ===== SEARCH FUNCTIONALITY =====
const VerdantSearch = {
    allProducts: window.INITIAL_PRODUCTS || [],

    formatPrice(n) { return new Intl.NumberFormat('vi-VN').format(n) + ' ₫'; },

    search(query) {
        if (!query || query.trim() === '') return this.allProducts;
        const q = query.toLowerCase();
        return this.allProducts.filter(p =>
            p.name.toLowerCase().includes(q) || p.vn.toLowerCase().includes(q) || (p.tag && p.tag.toLowerCase().includes(q))
        );
    },

    sort(products, sortBy) {
        const sorted = [...products];
        switch(sortBy) {
            case 'price-asc': sorted.sort((a,b) => a.price - b.price); break;
            case 'price-desc': sorted.sort((a,b) => b.price - a.price); break;
            case 'name': sorted.sort((a,b) => a.name.localeCompare(b.name)); break;
            default: break;
        }
        return sorted;
    },

    renderResults(products, containerId) {
        const container = document.getElementById(containerId);
        if (!container) return;
        const countEl = document.getElementById('search-count');
        if (countEl) countEl.textContent = products.length;

        container.innerHTML = products.map((p, i) => `
            <article class="group flex flex-col cursor-pointer" data-aos="fade-up" data-aos-delay="${i * 80}">
                <a href="/product?id=${p.id}" class="block">
                    <div class="relative w-full aspect-[4/5] overflow-hidden rounded-xl mb-3" style="background:#eceeec;">
                        <img alt="${p.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" src="${p.img}"/>
                        ${p.tag ? `<div class="absolute top-3 left-3"><span class="px-3 py-1.5 rounded-full text-xs font-semibold" style="background:rgba(180,205,184,0.9);color:#061b0e;">${p.tag}</span></div>` : ''}
                    </div>
                </a>
                <div class="flex flex-col flex-grow">
                    <h2 class="font-semibold text-base mb-0.5" style="color:#061b0e;font-family:'Noto Serif',serif;">${p.name}</h2>
                    <p class="text-sm mb-2" style="color:#72796f;">${p.vn}</p>
                    <div class="flex items-center justify-between mt-auto pt-2">
                        <span class="font-semibold" style="color:#291100;">${this.formatPrice(p.price)}</span>
                        <button onclick="event.preventDefault(); event.stopPropagation(); VerdantCart.add({id:'${p.id}',name:'${p.name}',price:${p.price},img:'${p.img}',variant:'${p.vn}'})" class="text-sm font-semibold px-3 py-1.5 rounded-full transition-all hover:scale-105" style="background:#061b0e;color:#fff;">Thêm vào giỏ</button>
                    </div>
                </div>
            </article>
        `).join('');
        if (typeof AOS !== 'undefined') AOS.refresh();
    }
};

// ===== PRODUCT DETAIL =====
const VerdantProduct = {
    render() {
        const container = document.getElementById('product-detail-container');
        if (!container) return;
        
        const params = new URLSearchParams(window.location.search);
        let id = params.get('id') || 'ficus-lyrata'; // Default to Fiddle Leaf Fig
        let product = VerdantSearch.allProducts.find(p => p.id === id);
        
        if (!product && VerdantSearch.allProducts.length > 0) {
            product = VerdantSearch.allProducts[0];
        } else if (!product) {
            return;
        }
        
        let catName = 'Cây cảnh';
        if (product.cat === 'desk') catName = 'Cây Để Bàn';
        if (product.cat === 'hanging') catName = 'Cây Dây Leo';
        if (product.cat === 'large') catName = 'Cây Trồng Sàn';

        let lightLevel = 'Ánh sáng trung bình';
        let lightDesc = 'Đặt cây gần cửa sổ có nắng, nhưng tránh ánh nắng gắt vào buổi chiều để không làm cháy lá.';
        if (product.light === 'low') {
            lightLevel = 'Ánh sáng yếu đến trung bình';
            lightDesc = 'Phát triển tốt trong điều kiện ánh sáng yếu. Tránh ánh nắng mặt trời trực tiếp.';
        } else if (product.light === 'high') {
            lightLevel = 'Ánh sáng mạnh, gián tiếp';
            lightDesc = 'Cần nhiều ánh sáng tự nhiên, gián tiếp để phát triển tốt nhất.';
        }

        container.innerHTML = `
        <!-- Product Image -->
        <div class="flex flex-col gap-8">
            <div class="w-full bg-surface-container-low rounded-lg overflow-hidden aspect-[4/5] relative">
                <img alt="${product.name}" class="w-full h-full object-cover" src="${product.img}"/>
                ${product.tag ? `<div class="absolute top-4 left-4"><span class="px-4 py-2 rounded-full text-sm font-semibold shadow-md" style="background:rgba(255,255,255,0.9);color:#061b0e;">${product.tag}</span></div>` : ''}
            </div>
        </div>
        <!-- Product Info -->
        <div class="flex flex-col justify-start">
            <!-- Breadcrumbs -->
            <nav class="flex gap-2 text-surface-tint font-label-sm text-sm mb-6">
                <a class="hover:underline" href="/category">Danh mục</a>
                <span>/</span>
                <a class="hover:underline" href="/category?cat=${product.cat}">${catName}</a>
            </nav>
            <!-- Title & Price -->
            <h1 class="font-display-lg text-4xl lg:text-5xl text-on-background mb-3" style="font-family: 'Playfair Display', serif; color: #061b0e;">${product.vn}</h1>
            <p class="font-headline-md text-2xl text-primary mb-6" style="font-weight: 600;">${VerdantSearch.formatPrice(product.price)}</p>
            <!-- Tags -->
            <div class="flex flex-wrap gap-2 mb-6">
                <span class="bg-surface-container px-3 py-1 rounded-full font-label-sm text-xs text-on-surface-variant">${product.name}</span>
                <span class="bg-surface-container px-3 py-1 rounded-full font-label-sm text-xs text-on-surface-variant">${lightLevel}</span>
            </div>
            <!-- Description -->
            <p class="font-body-lg text-base text-on-surface-variant mb-10 max-w-prose leading-relaxed">
                Đẹp mắt và tràn đầy sức sống, cây <strong>${product.vn}</strong> (${product.name}) mang đến một mảng xanh thiên nhiên cho không gian trong nhà. ${product.tag ? 'Nổi bật với đặc tính ' + product.tag.toLowerCase() + ', đây' : 'Đây'} là một điểm nhấn hoàn hảo cho bất kỳ căn phòng nào, và cần điều kiện ${lightLevel.toLowerCase()} để phát triển tốt nhất.
            </p>
            <!-- Actions -->
            <div class="flex flex-col gap-4 mb-10 border-b border-surface-variant pb-8">
                <button onclick="event.preventDefault(); VerdantCart.add({id:'${product.id}',name:'${product.name}',price:${product.price},img:'${product.img}',variant:'${product.vn}'})" class="bg-[#061b0e] text-white font-label-md text-base py-4 px-8 rounded-full hover:bg-opacity-90 transition-colors w-full md:w-auto text-center font-semibold shadow-md">
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
                        <h3 class="font-label-md text-base font-semibold text-on-background">${lightLevel}</h3>
                        <p class="font-body-md text-sm text-on-surface-variant mt-1">${lightDesc}</p>
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
        `;
    }
};

// ===== CATEGORY SORTING =====
const VerdantCategory = {
    products: VerdantSearch.allProducts,
    currentSort: 'popular',
    activeFilters: { cat: [], light: [] },

    init() {
        const sortSelect = document.getElementById('category-sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.currentSort = e.target.value;
                this.applyFilters();
            });
        }
        // Checkbox filters
        document.querySelectorAll('.filter-checkbox').forEach(cb => {
            cb.addEventListener('change', () => this.applyFilters());
        });
        
        // Apply filters immediately to account for browser back navigation preserving checkbox states
        this.applyFilters();
    },

    applyFilters() {
        let filtered = [...this.products];
        const catChecked = [...document.querySelectorAll('.filter-cat:checked')].map(c => c.value);
        const lightChecked = [...document.querySelectorAll('.filter-light:checked')].map(c => c.value);
        const tagChecked = [...document.querySelectorAll('.filter-tag:checked')].map(c => c.value);
        if (catChecked.length) filtered = filtered.filter(p => catChecked.includes(p.cat));
        if (lightChecked.length) filtered = filtered.filter(p => lightChecked.includes(p.light));
        if (tagChecked.length) {
            filtered = filtered.filter(p => {
                if (!p.tag) return false;
                return tagChecked.some(t => {
                    if (t === 'Lọc khí') return p.tag.includes('Lọc không khí') || p.tag.includes('Lọc khí');
                    return p.tag.includes(t);
                });
            });
        }
        filtered = VerdantSearch.sort(filtered, this.currentSort);
        this.render(filtered);
    },

    render(products) {
        const grid = document.getElementById('category-grid');
        if (!grid) return;
        const countEl = document.getElementById('category-count');
        if (countEl) countEl.textContent = `Showing ${products.length} plants`;

        grid.innerHTML = products.map((p, i) => `
            <a href="/product?id=${p.id}" class="group cursor-pointer block" data-aos="fade-up" data-aos-delay="${i * 60}">
                <div class="relative rounded-xl overflow-hidden aspect-[4/5] mb-3" style="background:#eceeec;">
                    <img alt="${p.name}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" src="${p.img}"/>
                    ${p.tag ? `<div class="absolute top-3 left-3"><span class="px-3 py-1.5 rounded-full text-xs font-semibold" style="background:rgba(180,205,184,0.9);color:#061b0e;">${p.tag}</span></div>` : ''}
                    <button onclick="event.preventDefault(); event.stopPropagation(); VerdantCart.add({id:'${p.id}',name:'${p.name}',price:${p.price},img:'${p.img}',variant:'${p.vn}'})" class="absolute bottom-3 right-3 w-11 h-11 rounded-full flex items-center justify-center opacity-0 translate-y-3 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 shadow-lg" style="background:#061b0e;color:#fff;">
                        <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                    </button>
                </div>
                <h2 class="font-semibold" style="color:#061b0e;font-family:'Noto Serif',serif;">${p.name}</h2>
                <p class="text-sm mt-0.5" style="color:#72796f;">${VerdantSearch.formatPrice(p.price)}</p>
            </a>
        `).join('');
        if (typeof AOS !== 'undefined') AOS.refresh();
    }
};

// Expose to global window object so inline onclick handlers can access them
window.VerdantCart = VerdantCart;
window.VerdantSearch = VerdantSearch;
window.VerdantCategory = VerdantCategory;

// ===== INIT ON DOM READY =====
document.addEventListener('DOMContentLoaded', () => {
    VerdantCart.updateBadge();

    // Cart page
    if (document.getElementById('cart-items')) VerdantCart.renderCart();

    // Checkout page
    if (document.getElementById('checkout-items')) VerdantCart.renderCheckout();

    // Category page
    if (document.getElementById('category-grid')) VerdantCategory.init();
    
    // Product Detail page
    if (document.getElementById('product-detail-container')) VerdantProduct.render();

    // Search page
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let debounce;
        const doSearch = () => {
            const q = searchInput.value;
            const results = VerdantSearch.search(q);
            VerdantSearch.renderResults(results, 'search-results');
        };
        searchInput.addEventListener('input', () => { clearTimeout(debounce); debounce = setTimeout(doSearch, 300); });
        // Initial render
        doSearch();
    }

    // Search sort
    const searchSort = document.getElementById('search-sort');
    if (searchSort) {
        searchSort.addEventListener('change', () => {
            const q = document.getElementById('search-input')?.value || '';
            let results = VerdantSearch.search(q);
            results = VerdantSearch.sort(results, searchSort.value);
            VerdantSearch.renderResults(results, 'search-results');
        });
    }

    // Vanilla Tilt on product cards
    if (typeof VanillaTilt !== 'undefined') {
        VanillaTilt.init(document.querySelectorAll('.tilt-card'), { max: 8, speed: 400, glare: true, 'max-glare': 0.15 });
    }

    // GSAP hero animation
    if (typeof gsap !== 'undefined' && document.querySelector('.hero-title')) {
        gsap.from('.hero-title', { y: 60, opacity: 0, duration: 1.2, ease: 'power3.out' });
        gsap.from('.hero-subtitle', { y: 40, opacity: 0, duration: 1, delay: 0.3, ease: 'power3.out' });
        gsap.from('.hero-cta', { y: 30, opacity: 0, duration: 0.8, delay: 0.6, ease: 'power3.out' });
    }

    // ScrollReveal for sections
    if (typeof ScrollReveal !== 'undefined') {
        ScrollReveal().reveal('.sr-reveal', { distance: '30px', duration: 800, easing: 'ease-out', origin: 'bottom', interval: 100 });
    }

    // Flash messages
    const flash = document.querySelector('meta[name="flash-success"]');
    if (flash && flash.content && typeof notyf !== 'undefined') {
        notyf.success(flash.content);
    }
});

// Handle BFCache (browser back/forward button)
window.addEventListener('pageshow', (event) => {
    if (event.persisted && window.location.pathname.includes('/category')) {
        setTimeout(() => {
            if (window.VerdantCategory) {
                VerdantCategory.applyFilters();
            }
        }, 10);
    }
});
