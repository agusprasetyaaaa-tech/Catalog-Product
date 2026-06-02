<?php $__env->startSection('title', 'Product Catalog'); ?>

<?php $__env->startSection('content'); ?>
    
    <header class="site-header" id="siteHeader">
        <div style="display: flex; align-items: center; gap: 12px;">
            <img src="<?php echo e($logoUrl); ?>" alt="Logo INTERPRIMA INDOCOM" style="height: 38px; width: auto; object-fit: contain;" />
            <span class="site-header__brand" style="letter-spacing: 0.12em;">INTERPRIMA INDOCOM</span>
        </div>
    </header>

    
    <section class="hero">
        <h1 class="hero__title">Our Product</h1>
        <div class="hero__divider"></div>
        <p class="hero__subtitle"><?php echo e($heroSubtitle); ?></p>
    </section>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brands->count() > 0 && $products->count() > 0): ?>
        <div class="filter-container">
            <div class="filter-bar" role="tablist" aria-label="Filter berdasarkan Brand">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button 
                        class="filter-btn <?php echo e($index === 0 ? 'active' : ''); ?>" 
                        role="tab" 
                        aria-selected="<?php echo e($index === 0 ? 'true' : 'false'); ?>" 
                        data-filter="<?php echo e($brand->slug); ?>"
                        onclick="filterBrand('<?php echo e($brand->slug); ?>', this)"
                    >
                        <?php echo e($brand->name); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($products->count() > 0): ?>
        <?php
            $firstBrandSlug = $brands->first() ? $brands->first()->slug : '';
            $globalCardIndex = 0;
        ?>
        <div id="catalogGridContainer" style="max-width: 1400px; margin: 0 auto;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $isFirstBrand = $brand->slug === $firstBrandSlug;
                ?>
                <div class="brand-section <?php echo e($isFirstBrand ? '' : 'hidden'); ?>" 
                     data-brand="<?php echo e($brand->slug); ?>"
                     style="opacity: <?php echo e($isFirstBrand ? '1' : '0'); ?>; transform: scale(<?php echo e($isFirstBrand ? '1' : '0.98'); ?>); transition: opacity 300ms ease, transform 300ms ease;">
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $brand->productGroups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $groupProducts = $products->filter(fn($p) => $p->brand_id === $brand->id && $p->product_group_id === $group->id);
                        ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($groupProducts->count() > 0): ?>
                            <div class="group-wrapper" style="margin-bottom: 48px; padding: 0 24px;">
                                <h2 class="group-title" style="font-family: var(--font-display); border-bottom: 2px solid rgba(22, 101, 52, 0.1); padding-bottom: 8px; margin-bottom: 24px; color: #1e293b; font-size: 1.125rem; font-weight: 700; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                                    <?php echo e($group->name); ?>

                                </h2>
                                <main class="catalog-grid" style="padding: 0 0 20px;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $groupProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <article
                                            class="product-card <?php echo e($isFirstBrand ? '' : 'hidden'); ?>"
                                            data-index="<?php echo e($globalCardIndex++); ?>"
                                            data-brand="<?php echo e($brand->slug); ?>"
                                            data-name="<?php echo e($product->name); ?>"
                                            data-brand-name="<?php echo e($brand->name); ?>"
                                            data-description="<?php echo e($product->description ?? ''); ?>"
                                            data-is-pdf="<?php echo e($product->isPdf() ? 'true' : 'false'); ?>"
                                            data-show-description="<?php echo e($product->show_description ? 'true' : 'false'); ?>"
                                            data-url="<?php echo e($product->image_url); ?>"
                                            data-thumbnail-url="<?php echo e($product->thumbnail_url); ?>"
                                            data-pdf-pages="<?php echo e(json_encode($product->pdf_pages_urls)); ?>"
                                            onclick="openLightbox('<?php echo e($product->image_url); ?>', this)"
                                            role="button"
                                            tabindex="0"
                                            aria-label="Lihat foto <?php echo e($product->name); ?>"
                                        >
                                            <div class="product-card__image-wrapper" style="position: relative;">
                                                <img
                                                    class="product-card__image"
                                                    src="<?php echo e($product->thumbnail_url); ?>"
                                                    alt="<?php echo e($product->name); ?>"
                                                    loading="lazy"
                                                    decoding="async"
                                                />
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->isPdf()): ?>
                                                    <!-- Tiny elegant overlay badge to indicate it is a PDF document -->
                                                    <div class="pdf-badge" style="position: absolute; bottom: 12px; right: 12px; background: rgba(220, 38, 38, 0.95); color: #ffffff; font-size: 0.625rem; font-weight: 700; letter-spacing: 0.05em; padding: 5px 9px; border-radius: 6px; display: flex; align-items: center; gap: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 5;">
                                                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                            <polyline points="14 2 14 8 20 8"></polyline>
                                                        </svg>
                                                        PDF
                                                    </div>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div class="product-card__info">
                                                <span class="product-card__brand"><?php echo e($brand->name); ?></span>
                                                <h3 class="product-card__name"><?php echo e($product->name); ?></h3>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->description && $product->show_description && !$product->isPdf()): ?>
                                                    <p class="product-card__description"><?php echo e(Str::limit($product->description, 100)); ?></p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </article>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </main>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php
                        $ungroupedProducts = $products->filter(fn($p) => $p->brand_id === $brand->id && is_null($p->product_group_id));
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ungroupedProducts->count() > 0): ?>
                        <div class="group-wrapper" style="margin-bottom: 48px; padding: 0 24px;">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($brand->productGroups->count() > 0): ?>
                                <h2 class="group-title" style="font-family: var(--font-display); border-bottom: 2px solid rgba(22, 101, 52, 0.1); padding-bottom: 8px; margin-bottom: 24px; color: #1e293b; font-size: 1.125rem; font-weight: 700; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                                    Others
                                </h2>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <main class="catalog-grid" style="padding: 0 0 20px;">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $ungroupedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <article
                                        class="product-card <?php echo e($isFirstBrand ? '' : 'hidden'); ?>"
                                        data-index="<?php echo e($globalCardIndex++); ?>"
                                        data-brand="<?php echo e($brand->slug); ?>"
                                        data-name="<?php echo e($product->name); ?>"
                                        data-brand-name="<?php echo e($brand->name); ?>"
                                        data-description="<?php echo e($product->description ?? ''); ?>"
                                        data-is-pdf="<?php echo e($product->isPdf() ? 'true' : 'false'); ?>"
                                        data-show-description="<?php echo e($product->show_description ? 'true' : 'false'); ?>"
                                        data-url="<?php echo e($product->image_url); ?>"
                                        data-thumbnail-url="<?php echo e($product->thumbnail_url); ?>"
                                        data-pdf-pages="<?php echo e(json_encode($product->pdf_pages_urls)); ?>"
                                        onclick="openLightbox('<?php echo e($product->image_url); ?>', this)"
                                        role="button"
                                        tabindex="0"
                                        aria-label="Lihat foto <?php echo e($product->name); ?>"
                                    >
                                        <div class="product-card__image-wrapper" style="position: relative;">
                                            <img
                                                class="product-card__image"
                                                src="<?php echo e($product->thumbnail_url); ?>"
                                                alt="<?php echo e($product->name); ?>"
                                                loading="lazy"
                                                decoding="async"
                                            />
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->isPdf()): ?>
                                                <!-- Tiny elegant overlay badge to indicate it is a PDF document -->
                                                <div class="pdf-badge" style="position: absolute; bottom: 12px; right: 12px; background: rgba(220, 38, 38, 0.95); color: #ffffff; font-size: 0.625rem; font-weight: 700; letter-spacing: 0.05em; padding: 5px 9px; border-radius: 6px; display: flex; align-items: center; gap: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 5;">
                                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                                        <polyline points="14 2 14 8 20 8"></polyline>
                                                    </svg>
                                                    PDF
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div class="product-card__info">
                                            <span class="product-card__brand"><?php echo e($brand->name); ?></span>
                                            <h3 class="product-card__name"><?php echo e($product->name); ?></h3>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($product->description && $product->show_description && !$product->isPdf()): ?>
                                                <p class="product-card__description"><?php echo e(Str::limit($product->description, 100)); ?></p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </article>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </main>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <svg class="empty-state__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
            </svg>
            <p class="empty-state__text">No products available in the catalog.</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <style>
        .lightbox__pdf-pages {
            display: none;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            padding: 24px 24px 60px;
            box-sizing: border-box;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch; /* Butter smooth scrolling on iOS Safari */
        }
        
        /* Sleek scrollbar for PDF pages scroll container */
        .lightbox__pdf-pages::-webkit-scrollbar {
            width: 6px;
        }
        .lightbox__pdf-pages::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.02);
        }
        .lightbox__pdf-pages::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 3px;
        }
        .lightbox__pdf-pages::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.25);
        }
        
        .lightbox__pdf-page-img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 8px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            transition: transform 300ms ease;
        }
        .lightbox__pdf-page-img:hover {
            transform: scale(1.01);
        }
        @media (max-width: 768px) {
            .lightbox__pdf-pages {
                padding: 16px 16px 48px;
                gap: 14px;
            }
        }
    </style>

    <div class="lightbox" id="lightbox" onclick="closeLightbox(event)" role="dialog" aria-modal="true" aria-label="Product preview">
        <button class="lightbox__close" onclick="closeLightbox()" aria-label="Close preview" id="lightboxClose">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <!-- Split Layout Container -->
        <div class="lightbox__panel" onclick="event.stopPropagation()">
            <!-- LEFT: Image Side -->
            <div class="lightbox__image-side">
                <button class="lightbox__nav lightbox__nav--prev" onclick="navigateLightbox(-1, event)" aria-label="Previous photo" id="lightboxPrev">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>

                <div class="lightbox__image-container">
                    <img class="lightbox__image" id="lightboxImage" src="" alt="Preview produk" />
                    <iframe class="lightbox__image" id="lightboxPdf" src="" style="display: none; border: none; width: 100%; height: 100%; transition: opacity 280ms ease;" allow="autoplay"></iframe>
                    
                    <!-- Multi-page PDF Container for scroll-to-read -->
                    <div id="lightboxPdfPages" class="lightbox__pdf-pages"></div>
                </div>

                <!-- Floating Overlay for Pure Image Mode -->
                <div class="lightbox__image-overlay" id="lightboxImageOverlay" style="display: none; position: absolute; bottom: 0; left: 0; right: 0; background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-top: 1px solid rgba(0, 0, 0, 0.06); padding: 16px 20px 20px; color: var(--text-primary); z-index: 8; text-align: left; pointer-events: none;">
                    <span class="lightbox__brand" id="lightboxOverlayBrand" style="color: #166534; background: #ecfdf5; border: 1px solid #d1fae5; display: inline-flex; align-items: center; font-size: 0.625rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; margin-bottom: 6px; padding: 4px 10px; border-radius: 6px;">BRAND</span>
                    <h2 class="lightbox__title" id="lightboxOverlayTitle" style="color: #111827; font-size: 1.125rem; font-weight: 700; line-height: 1.35; margin: 0; font-family: var(--font-display);">Product Name</h2>
                </div>

                <button class="lightbox__nav lightbox__nav--next" onclick="navigateLightbox(1, event)" aria-label="Next photo" id="lightboxNext">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>

                <!-- Image Counter -->
                <span class="lightbox__counter" id="lightboxCounter">1 / 4</span>
            </div>

            <!-- RIGHT: Product Info Side -->
            <div class="lightbox__info" id="lightboxInfo">
                <div class="lightbox__info-inner">
                    <div class="lightbox__info-top">
                        <span class="lightbox__brand" id="lightboxBrand">BRAND</span>
                        <h2 class="lightbox__title" id="lightboxTitle">Product Name</h2>
                    </div>

                    <div class="lightbox__divider"></div>

                    <div class="lightbox__desc-section">
                        <div class="lightbox__desc-header">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 6h16M4 12h16M4 18h10"></path>
                            </svg>
                            <h3 class="lightbox__desc-label">Product Details</h3>
                        </div>
                        <div class="lightbox__desc-wrapper">
                            <p class="lightbox__description" id="lightboxDescription">Product description...</p>
                        </div>
                    </div>




                </div>

                <div class="lightbox__info-footer">
                    <span class="lightbox__footer-text">ESC to close • Arrows to navigate</span>
                </div>
            </div>
        </div>
    </div>

    
    <footer class="site-footer">
        <p class="site-footer__text">&copy; <?php echo e(date('Y')); ?> PT. Interprima Indocom. All rights reserved.</p>
    </footer>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    /**
     * ============================================
     * BRAND FILTERING — Client-Side Transition
     * ============================================
     */
    function filterBrand(brandSlug, btn) {
        if (!btn) return;

        // 1. Update active state of buttons
        const buttons = document.querySelectorAll('.filter-btn');
        buttons.forEach(button => {
            button.classList.remove('active');
            button.setAttribute('aria-selected', 'false');
        });
        btn.classList.add('active');
        btn.setAttribute('aria-selected', 'true');

        const brandSections = document.querySelectorAll('.brand-section');
        const activeSection = document.querySelector(`.brand-section[data-brand="${brandSlug}"]`);

        // 2. Animate out all sections
        brandSections.forEach(section => {
            section.style.opacity = '0';
            section.style.transform = 'scale(0.98)';
            section.style.transition = 'opacity 200ms ease, transform 200ms ease';
        });

        // 3. After fade-out, switch visibility and fade-in the selected section
        setTimeout(() => {
            let visibleCount = 0;
            
            brandSections.forEach(section => {
                if (section.dataset.brand === brandSlug) {
                    section.classList.remove('hidden');
                    
                    // Staggered reveal for cards inside the active section
                    const cards = section.querySelectorAll('.product-card');
                    cards.forEach((card, index) => {
                        card.classList.remove('hidden');
                        card.classList.remove('filtering');
                        card.classList.remove('visible');
                        
                        const delay = (index % 8) * 80;
                        setTimeout(() => {
                            card.classList.add('visible');
                        }, delay);
                    });
                    
                    // Fade in the section container itself
                    setTimeout(() => {
                        section.style.opacity = '1';
                        section.style.transform = 'scale(1)';
                    }, 50);
                    
                    visibleCount = cards.length;
                } else {
                    section.classList.add('hidden');
                    const cards = section.querySelectorAll('.product-card');
                    cards.forEach(card => {
                        card.classList.add('hidden');
                        card.classList.remove('visible');
                    });
                }
            });

            // Handle empty state
            let emptyState = document.getElementById('filteredEmptyState');
            const container = document.getElementById('catalogGridContainer');
            if (visibleCount === 0) {
                if (!emptyState) {
                    emptyState = document.createElement('div');
                    emptyState.id = 'filteredEmptyState';
                    emptyState.className = 'empty-state';
                    emptyState.innerHTML = `
                        <svg class="empty-state__icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0 0 22.5 18.75V5.25A2.25 2.25 0 0 0 20.25 3H3.75A2.25 2.25 0 0 0 1.5 5.25v13.5A2.25 2.25 0 0 0 3.75 21Z" />
                        </svg>
                        <p class="empty-state__text">No products available under this brand.</p>
                    `;
                    container.parentNode.insertBefore(emptyState, container.nextSibling);
                } else {
                    emptyState.style.display = 'block';
                }
            } else {
                if (emptyState) {
                    emptyState.style.display = 'none';
                }
            }
        }, 200);
    }

    /**
     * ============================================
     * HEADER SCROLL EFFECT
     * ============================================
     */
    (function() {
        const header = document.getElementById('siteHeader');
        let lastScroll = 0;
        let ticking = false;

        function updateHeader() {
            const scrollY = window.scrollY;
            if (scrollY > 10) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, { passive: true });
    })();

    /**
     * ============================================
     * INTERSECTION OBSERVER — Fade-in-up on Scroll
     * Staggered delay per card for elegant reveal
     * ============================================
     */
    (function() {
        const cards = document.querySelectorAll('.product-card');
        if (!cards.length) return;

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    const card = entry.target;
                    const index = parseInt(card.dataset.index, 10);
                    // Stagger: each card gets +80ms delay, reset per row batch
                    const delay = (index % 8) * 80;

                    setTimeout(function() {
                        card.classList.add('visible');
                    }, delay);

                    observer.unobserve(card);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -40px 0px'
        });

        cards.forEach(function(card) {
            observer.observe(card);
        });
    })();

    /**
     * ============================================
     * LIGHTBOX — Open / Close / Swipe / Navigation
     * ============================================
     */
    const lightbox = document.getElementById('lightbox');
    const lightboxImage = document.getElementById('lightboxImage');
    const lightboxPdf = document.getElementById('lightboxPdf');
    const lightboxActionSection = document.getElementById('lightboxActionSection');
    const lightboxPdfButton = document.getElementById('lightboxPdfButton');
    const lightboxPdfPages = document.getElementById('lightboxPdfPages');

    let currentVisibleCards = [];
    let currentActiveIndex = -1;

    function updateLightboxInfo(cardElement) {
        if (!cardElement) return;

        const name = cardElement.dataset.name || '';
        const brand = cardElement.dataset.brandName || '';
        const description = cardElement.dataset.description || '';
        const isPdf = cardElement.dataset.isPdf === 'true';
        const showDescription = cardElement.dataset.showDescription === 'true';

        const brandEl = document.getElementById('lightboxBrand');
        const titleEl = document.getElementById('lightboxTitle');
        const descEl = document.getElementById('lightboxDescription');
        const infoEl = document.getElementById('lightboxInfo');
        const descSection = document.querySelector('.lightbox__desc-section');

        // Layout expansion elements
        const imageSide = document.querySelector('.lightbox__image-side');
        const infoSide = document.querySelector('.lightbox__info');
        const imageOverlay = document.getElementById('lightboxImageOverlay');
        const overlayBrand = document.getElementById('lightboxOverlayBrand');
        const overlayTitle = document.getElementById('lightboxOverlayTitle');

        if (isPdf) {
            // Hide info side completely for PDF (Full Display)
            if (infoSide) infoSide.style.display = 'none';
            
            // Expand image side to 100%
            if (imageSide) {
                imageSide.style.flex = '0 0 100%';
                imageSide.style.width = '100%';
                imageSide.style.height = '100%';
            }
            
            // Hide floating overlay (No brand / product name for PDF previews)
            if (imageOverlay) imageOverlay.style.display = 'none';
            
        } else if (!showDescription || description.trim() === '') {
            // Pure Image Mode (when descriptions are disabled/empty)
            if (infoSide) infoSide.style.display = 'none';
            
            if (imageSide) {
                imageSide.style.flex = '0 0 100%';
                imageSide.style.width = '100%';
                imageSide.style.height = '100%';
            }
            
            if (imageOverlay) {
                imageOverlay.style.display = 'block';
                if (overlayTitle) overlayTitle.textContent = name;
                if (overlayBrand) {
                    overlayBrand.textContent = brand;
                    if (brand.trim() === '') {
                        overlayBrand.style.display = 'none';
                    } else {
                        overlayBrand.style.display = 'inline-flex';
                    }
                }
            }
        } else {
            // Restore standard layout for images with description
            if (infoSide) infoSide.style.display = 'flex';
            
            if (imageSide) {
                imageSide.style.flex = '';
                imageSide.style.width = '';
                imageSide.style.height = '';
            }
            
            if (imageOverlay) {
                imageOverlay.style.display = 'none';
            }

            if (brandEl) {
                brandEl.textContent = brand;
                if (brand.trim() === '') {
                    brandEl.style.display = 'none';
                } else {
                    brandEl.style.display = 'inline-block';
                }
            }
            if (titleEl) titleEl.textContent = name;
            if (descEl) descEl.textContent = description;

            if (descEl) descEl.style.display = 'block';
            if (descSection) descSection.style.display = 'flex';
        }
    }

    function updateCounter() {
        const counterEl = document.getElementById('lightboxCounter');
        if (counterEl && currentVisibleCards.length > 0) {
            counterEl.textContent = (currentActiveIndex + 1) + ' / ' + currentVisibleCards.length;
        }
    }

    function renderPdfPages(cardElement) {
        if (!lightboxPdfPages) return;
        
        lightboxPdfPages.innerHTML = ''; // Clear previous images
        
        let pages = [];
        try {
            pages = JSON.parse(cardElement.dataset.pdfPages || '[]');
        } catch (e) {
            console.error("Failed to parse PDF pages", e);
        }
        
        if (pages.length === 0) {
            // Fallback to thumbnail or main url
            const fallbackUrl = cardElement.dataset.thumbnailUrl || cardElement.dataset.url;
            if (fallbackUrl) pages = [fallbackUrl];
        }
        
        pages.forEach((pageUrl, index) => {
            const img = document.createElement('img');
            img.className = 'lightbox__pdf-page-img';
            img.src = pageUrl;
            img.alt = `Halaman ${index + 1}`;
            img.loading = index === 0 ? 'eager' : 'lazy'; // Lazy load subsequent pages for lightning-fast performance
            lightboxPdfPages.appendChild(img);
        });
        
        // Reset scroll position to top
        lightboxPdfPages.scrollTop = 0;
    }

    function openLightbox(imageUrl, cardElement) {
        if (!imageUrl) return;

        // Retrieve current list of active (non-hidden) cards
        currentVisibleCards = Array.from(document.querySelectorAll('.product-card:not(.hidden)'));
        currentActiveIndex = currentVisibleCards.indexOf(cardElement);

        const isPdf = cardElement.dataset.isPdf === 'true';
        
        if (isPdf) {
            // Hide single image and iframe, show scrollable pages container
            lightboxImage.style.display = 'none';
            lightboxPdf.style.display = 'none';
            lightboxPdf.src = '';
            
            if (lightboxPdfPages) {
                lightboxPdfPages.style.display = 'flex';
                renderPdfPages(cardElement);
            }
        } else {
            // Show single image, hide PDF iframe and scrollable pages
            lightboxImage.style.display = 'block';
            lightboxPdf.style.display = 'none';
            lightboxPdf.src = '';
            if (lightboxPdfPages) {
                lightboxPdfPages.style.display = 'none';
                lightboxPdfPages.innerHTML = '';
            }
            
            // Reset image transition values
            lightboxImage.style.opacity = '1';
            lightboxImage.style.transform = 'scale(1)';
            lightboxImage.src = imageUrl;
        }

        updateLightboxInfo(cardElement);
        updateCounter();

        lightbox.classList.add('active');
        document.body.classList.add('lightbox-open');
    }

    function navigateLightbox(direction, event) {
        if (event) {
            event.stopPropagation(); // Prevent closing when clicking nav arrows
        }

        if (currentVisibleCards.length <= 1) return;

        // Calculate next index looping forwards or backwards
        currentActiveIndex = (currentActiveIndex + direction + currentVisibleCards.length) % currentVisibleCards.length;
        const nextCard = currentVisibleCards[currentActiveIndex];
        const nextUrl = nextCard.dataset.url;
        const isPdf = nextCard.dataset.isPdf === 'true';

        lightboxImage.style.opacity = '0';
        lightboxImage.style.transform = 'scale(0.95)';
        lightboxPdf.style.opacity = '0';

        setTimeout(() => {
            if (isPdf) {
                lightboxImage.style.display = 'none';
                lightboxPdf.style.display = 'none';
                lightboxPdf.src = '';
                
                if (lightboxPdfPages) {
                    lightboxPdfPages.style.display = 'flex';
                    renderPdfPages(nextCard);
                }
            } else {
                lightboxImage.style.display = 'block';
                lightboxPdf.style.display = 'none';
                lightboxPdf.src = '';
                if (lightboxPdfPages) {
                    lightboxPdfPages.style.display = 'none';
                    lightboxPdfPages.innerHTML = '';
                }
                
                lightboxImage.src = nextUrl;
                
                lightboxImage.onload = () => {
                    lightboxImage.style.opacity = '1';
                    lightboxImage.style.transform = 'scale(1)';
                };
            }
            updateLightboxInfo(nextCard);
        }, 120);

        updateCounter();
    }

    function closeLightbox(event) {
        // If clicking overlay, only close if clicking backdrop and not buttons/images
        if (event) {
            const isClickOnBackdrop = event.target === lightbox;
            const isClickOnCloseButton = event.target.closest('.lightbox__close');
            
            if (!isClickOnBackdrop && !isClickOnCloseButton) {
                return;
            }
        }

        lightbox.classList.remove('active');
        document.body.classList.remove('lightbox-open');

        // Clear resources after transition finishes
        setTimeout(function() {
            lightboxImage.src = '';
            lightboxPdf.src = '';
            if (lightboxPdfPages) {
                lightboxPdfPages.innerHTML = '';
            }
        }, 350);
    }

    // Keyboard support: Escape, Left & Right Arrows
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('active')) return;
        
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowRight' || e.key === 'd') {
            navigateLightbox(1);
        } else if (e.key === 'ArrowLeft' || e.key === 'a') {
            navigateLightbox(-1);
        }
    });

    // Keyboard accessibility: Enter on cards opens them
    document.querySelectorAll('.product-card').forEach(function(card) {
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                card.click();
            }
        });
    });

    /**
     * Touch & Swipe Gestures (Mobile Devices)
     */
    let touchStartX = 0;
    let touchEndX = 0;

    const imageSide = document.querySelector('.lightbox__image-side');

    imageSide.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    imageSide.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    function handleSwipe() {
        const threshold = 55; // Min distance in pixels to trigger swipe
        if (touchEndX < touchStartX - threshold) {
            navigateLightbox(1); // Swipe left -> next image
        } else if (touchEndX > touchStartX + threshold) {
            navigateLightbox(-1); // Swipe right -> previous image
        }
    }

    // Auto-filter brand based on URL query parameter (?brand=slug) or Hash (#slug)
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        let brandParam = urlParams.get('brand');
        
        // Fallback to URL hash if query param is not set
        if (!brandParam && window.location.hash) {
            brandParam = window.location.hash.substring(1);
        }
        
        if (brandParam) {
            const targetBtn = document.querySelector(`.filter-btn[data-filter="${brandParam}"]`);
            if (targetBtn) {
                // Instantly select/filter
                filterBrand(brandParam, targetBtn);
                // Smooth scroll to the filter bar
                setTimeout(() => {
                    targetBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 350);
            }
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/catalog/index.blade.php ENDPATH**/ ?>