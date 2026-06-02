<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="description" content="Premium Product Catalog - Our exclusive collection for enterprise partners.">
    <meta name="theme-color" content="#111111">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="{{ asset('logo/logo.png') }}" type="image/png">
    <title>@yield('title', 'Product Catalog')</title>

    <!-- Preconnect Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS v4 CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'system-ui', '-apple-system', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <style>
        /* ======================================================
           DESIGN SYSTEM — Premium Enterprise Product Catalog
           ====================================================== */

        :root {
            --font-sans: 'Inter', system-ui, -apple-system, sans-serif;
            --font-display: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --bg-page: #F8F8F8;
            --bg-card: #FFFFFF;
            --text-primary: #1A1A1A;
            --text-secondary: #6B7280;
            --text-tertiary: #9CA3AF;
            --border-subtle: rgba(0, 0, 0, 0.06);
            --shadow-rest: 0 1px 3px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 16px 40px rgba(0, 0, 0, 0.08);
            --radius-card: 16px;
            --radius-image: 12px;
            --transition-smooth: 300ms ease-in-out;
            --transition-spring: 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--bg-page);
            color: var(--text-primary);
            overflow-x: hidden;
        }

        body.lightbox-open {
            overflow: hidden;
        }

        /* ======================================================
           HEADER — Floating with Backdrop Blur
           ====================================================== */

        .site-header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(248, 248, 248, 0.72);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-bottom: 1px solid transparent;
            transition: border-color var(--transition-smooth),
                        background-color var(--transition-smooth),
                        box-shadow var(--transition-smooth);
        }

        .site-header.scrolled {
            background-color: rgba(255, 255, 255, 0.88);
            border-bottom-color: var(--border-subtle);
            box-shadow: 0 1px 12px rgba(0, 0, 0, 0.03);
        }

        .site-header__brand {
            font-family: var(--font-display);
            font-size: 1.125rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--text-primary);
            user-select: none;
        }

        @media (max-width: 640px) {
            .site-header__brand {
                font-size: 0.9375rem;
                letter-spacing: 0.1em;
            }
        }

        /* ======================================================
           HERO SECTION — Elegant, Centered
           ====================================================== */

        .hero {
            padding-top: 144px;
            padding-bottom: 32px;
            text-align: center;
            opacity: 0;
            transform: translateY(16px);
            animation: heroFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.2s forwards;
        }

        @keyframes heroFadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero__title {
            font-family: var(--font-display);
            font-size: 2.25rem;
            font-weight: 600;
            letter-spacing: -0.02em;
            color: var(--text-primary);
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .hero__divider {
            width: 32px;
            height: 1px;
            background-color: var(--text-tertiary);
            margin: 0 auto 14px;
            opacity: 0.4;
        }

        .hero__subtitle {
            font-family: var(--font-sans);
            font-size: 0.875rem;
            font-weight: 400;
            color: var(--text-secondary);
            letter-spacing: 0.01em;
            line-height: 1.6;
        }

        @media (max-width: 640px) {
            .hero {
                padding-top: 108px;
                padding-bottom: 18px;
            }
            .hero__title {
                font-size: 1.625rem;
                letter-spacing: -0.01em;
            }
            .hero__subtitle {
                font-size: 0.75rem;
                padding: 0 24px;
            }
        }

        /* ======================================================
           PRODUCT GRID — Responsive, Symmetric
           ====================================================== */

        .catalog-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 0 16px;
            max-width: 1320px;
            margin: 0 auto;
            padding-bottom: 80px;
        }

        @media (min-width: 640px) {
            .catalog-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
                padding-left: 32px;
                padding-right: 32px;
                padding-bottom: 100px;
            }
        }

        @media (min-width: 1024px) {
            .catalog-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 24px;
                padding-left: 48px;
                padding-right: 48px;
                padding-bottom: 120px;
            }
        }

        @media (min-width: 1400px) {
            .catalog-grid {
                padding-left: 0;
                padding-right: 0;
            }
        }

        /* ======================================================
           PRODUCT CARD — Borderless, Minimal
           ====================================================== */

        .product-card {
            background: var(--bg-card);
            border-radius: var(--radius-card);
            padding: 8px;
            box-shadow: var(--shadow-rest);
            cursor: pointer;
            overflow: hidden;
            position: relative;

            /* Fade-in-up initial state */
            opacity: 0;
            transform: translateY(28px);
            transition: opacity var(--transition-spring),
                        transform var(--transition-spring),
                        box-shadow var(--transition-smooth);
        }

        .product-card.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .product-card:hover {
            box-shadow: var(--shadow-hover);
        }

        .product-card.visible:hover {
            transform: translateY(-3px);
        }

        /* Image Wrapper — Portrait Aspect Ratio */
        .product-card__image-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 1 / 1;
            border-radius: var(--radius-image);
            overflow: hidden;
            background-color: #F1F2F4;
        }

        .product-card__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 600ms cubic-bezier(0.16, 1, 0.3, 1);
            will-change: transform;
            mix-blend-mode: multiply;
        }

        .product-card:hover .product-card__image {
            transform: scale(1.04);
        }

        /* Subtle overlay gradient on hover for depth */
        .product-card__image-wrapper::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                rgba(0, 0, 0, 0.02) 0%,
                transparent 40%);
            border-radius: var(--radius-image);
            pointer-events: none;
            opacity: 0;
            transition: opacity var(--transition-smooth);
        }

        .product-card:hover .product-card__image-wrapper::after {
            opacity: 1;
        }


        /* ======================================================
           PRODUCT CARD INFO — Name & Description Below Image
           ====================================================== */

        .product-card__info {
            padding: 14px 8px 8px;
            text-align: left;
        }

        .product-card__brand {
            display: inline-block;
            font-family: var(--font-display);
            font-size: 0.625rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #166534;
            margin-bottom: 5px;
            opacity: 0.85;
        }

        .product-card__name {
            font-family: var(--font-display);
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.35;
            margin-bottom: 6px;
            letter-spacing: -0.01em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-card__description {
            font-family: var(--font-sans);
            font-size: 0.75rem;
            font-weight: 400;
            color: #4b5563;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0;
        }

        @media (max-width: 640px) {
            .product-card__info {
                padding: 10px 6px 6px;
            }
            .product-card__name {
                font-size: 0.8125rem;
                line-height: 1.3;
            }
            .product-card__description {
                font-size: 0.6875rem;
                -webkit-line-clamp: 2;
                line-height: 1.4;
            }
        }

        /* ======================================================
           LIGHTBOX MODAL — Full-Screen, Immersive
           ====================================================== */

        .lightbox {
            position: fixed;
            inset: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background-color: rgba(0, 0, 0, 0);
            visibility: hidden;
            transition: background-color 350ms ease,
                        visibility 0s linear 350ms,
                        padding 350ms ease;
        }

        .lightbox.active {
            background-color: rgba(10, 10, 10, 0.94);
            visibility: visible;
            transition: background-color 350ms ease,
                        visibility 0s linear 0s;
        }

        /* lightbox__image-container and lightbox__image styles moved to split panel section */

        .lightbox__close {
            position: fixed;
            top: 18px;
            right: 20px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.08);
            color: #1f2937;
            font-size: 1.125rem;
            cursor: pointer;
            border-radius: 50%;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
            transition: color 200ms ease,
                        background-color 200ms ease,
                        border-color 200ms ease,
                        transform 200ms ease;
            z-index: 1001;
            line-height: 1;
        }

        .lightbox__close:hover {
            color: #fff;
            background-color: rgba(220, 38, 38, 0.7);
            border-color: rgba(220, 38, 38, 0.5);
            transform: scale(1.05);
        }

        /* lightbox__hint styles moved to split panel section */

        /* ======================================================
           FOOTER — Ultra-Minimal
           ====================================================== */

        .site-footer {
            text-align: center;
            padding: 36px 16px;
            border-top: 1px solid var(--border-subtle);
        }

        .site-footer__text {
            font-size: 0.6875rem;
            color: var(--text-tertiary);
            letter-spacing: 0.04em;
        }

        /* ======================================================
           EMPTY STATE
           ====================================================== */

        .empty-state {
            text-align: center;
            padding: 120px 24px;
            opacity: 0;
            animation: heroFadeIn 0.6s ease 0.3s forwards;
        }

        .empty-state__icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            opacity: 0.2;
        }

        .empty-state__text {
            font-size: 0.9375rem;
            color: var(--text-secondary);
            font-weight: 400;
        }

        /* ======================================================
           BRAND FILTER BAR — Premium, Glassmorphism
           ====================================================== */

        .filter-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 76px;
            padding: 0 16px;
            opacity: 0;
            transform: translateY(10px);
            animation: heroFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) 0.4s forwards;
        }

        .filter-bar {
            display: flex;
            gap: 6px;
            background: rgba(255, 255, 255, 0.64);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: 6px;
            border-radius: 30px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.015);
            overflow-x: auto;
            scrollbar-width: none; /* Firefox */
            max-width: 100%;
            white-space: nowrap;
        }

        .filter-bar::-webkit-scrollbar {
            display: none; /* Safari and Chrome */
        }

        .filter-btn {
            background: transparent;
            border: none;
            outline: none;
            padding: 6px 18px;
            font-family: var(--font-display);
            font-size: 0.625rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--text-secondary);
            border-radius: 20px;
            cursor: pointer;
            transition: color 250ms ease,
                        background-color 250ms ease,
                        transform 200ms ease;
        }

        .filter-btn:hover {
            color: var(--text-primary);
        }

        .filter-btn.active {
            background-color: #166534;
            color: #FFFFFF;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        /* Product card filter state */
        .product-card.hidden {
            display: none !important;
            opacity: 0;
            transform: scale(0.8) translateY(20px);
        }

        .product-card.filtering {
            transition: opacity 250ms ease, transform 250ms ease;
            opacity: 0;
            transform: scale(0.9) translateY(10px);
        }

        /* ======================================================
           SCROLLBAR — Sleek & Minimal
           ====================================================== */

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.18);
        }

        /* Firefox */
        html {
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.1) transparent;
        }

        /* ======================================================
           LIGHTBOX — Enterprise Split Panel (Image Left, Info Right)
           ====================================================== */

        .lightbox__panel {
            display: flex;
            flex-direction: row;
            width: 92vw;
            max-width: 1100px;
            height: 78vh;
            max-height: 720px;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.35),
                        0 0 0 1px rgba(0, 0, 0, 0.04);
            opacity: 0;
            transform: scale(0.96) translateY(8px);
            transition: opacity 350ms cubic-bezier(0.16, 1, 0.3, 1),
                        transform 350ms cubic-bezier(0.16, 1, 0.3, 1);
        }

        .lightbox.active .lightbox__panel {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        /* ---------- LEFT: Image Side ---------- */

        .lightbox__image-side {
            position: relative;
            flex: 0 0 55%;
            background: #ffffff;
            display: flex;
            align-items: stretch;
            justify-content: center;
            overflow: hidden;
            min-height: 0;
        }

        .lightbox__image-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .lightbox__image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background-color: #ffffff;
            padding: 24px 24px 52px;
            box-sizing: border-box;
            display: block;
            opacity: 1;
            transform: scale(1);
            transition: opacity 280ms ease,
                        transform 280ms ease;
            user-select: none;
            -webkit-user-drag: none;
            border-radius: 0;
            box-shadow: none;
        }

        /* Subtle vignette overlay on image for depth */
        .lightbox__image-side::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to right,
                rgba(0, 0, 0, 0.02) 0%,
                transparent 15%,
                transparent 85%,
                rgba(0, 0, 0, 0.04) 100%
            );
            pointer-events: none;
            z-index: 2;
        }

        /* Image Navigation Overlay Controls */
        .lightbox__nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.76);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.06);
            color: #374151;
            font-size: 1.125rem;
            cursor: pointer;
            border-radius: 50%;
            transition: all 250ms cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 10;
            user-select: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .lightbox__nav:hover {
            background: rgba(255, 255, 255, 0.95);
            color: #111827;
            border-color: rgba(0, 0, 0, 0.1);
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        .lightbox__nav:active {
            transform: translateY(-50%) scale(0.95);
        }

        .lightbox__nav--prev {
            left: 20px;
        }

        .lightbox__nav--next {
            right: 20px;
        }

        /* Image Position Counter Pill */
        .lightbox__counter {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 0, 0, 0.06);
            color: #4b5563;
            font-size: 0.6875rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            padding: 5px 12px;
            border-radius: 20px;
            z-index: 10;
            pointer-events: none;
            user-select: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* ---------- RIGHT: Product Info Side ---------- */

        .lightbox__info {
            flex: 0 0 45%;
            background: linear-gradient(165deg, #fdfdfd 0%, #f5f6f8 100%);
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            overflow: hidden;
            border-left: 1px solid #eaeaea;
        }

        .lightbox__info-inner {
            flex: 1;
            padding: 40px 36px 24px;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.06) transparent;
        }

        .lightbox__info-inner::-webkit-scrollbar {
            width: 3px;
        }

        .lightbox__info-inner::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.08);
            border-radius: 2px;
        }

        .lightbox__info-top {
            margin-bottom: 0;
        }

        .lightbox__brand {
            display: inline-flex;
            align-items: center;
            font-family: var(--font-display);
            font-size: 0.625rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #047857;
            margin-bottom: 14px;
            padding: 5px 14px;
            background: #ecfdf5;
            border: 1px solid #d1fae5;
            border-radius: 6px;
        }

        .lightbox__title {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.02em;
            margin-bottom: 0;
            line-height: 1.3;
        }

        .lightbox__divider {
            width: 100%;
            height: 1px;
            background: #eaeaea;
            margin: 28px 0 24px;
            flex-shrink: 0;
        }

        .lightbox__desc-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .lightbox__desc-header {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            color: #6b7280;
        }

        .lightbox__desc-label {
            font-family: var(--font-display);
            font-size: 0.6875rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #6b7280;
            margin: 0;
        }

        .lightbox__desc-wrapper {
            flex: 1;
            overflow-y: auto;
            padding-right: 12px;
            scrollbar-width: thin;
            scrollbar-color: rgba(0, 0, 0, 0.06) transparent;
        }

        .lightbox__desc-wrapper::-webkit-scrollbar {
            width: 3px;
        }

        .lightbox__desc-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .lightbox__desc-wrapper::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.08);
            border-radius: 2px;
        }

        .lightbox__description {
            font-family: var(--font-sans);
            font-size: 0.8125rem;
            line-height: 1.7;
            color: #374151;
            font-weight: 400;
            letter-spacing: 0;
            white-space: pre-wrap;
        }

        /* Info Footer — subtle bar at bottom */
        .lightbox__info-footer {
            padding: 14px 36px;
            border-top: 1px solid #eaeaea;
            background: #f3f4f6;
            flex-shrink: 0;
        }

        .lightbox__footer-text {
            font-size: 0.625rem;
            color: #9ca3af;
            font-weight: 500;
            letter-spacing: 0.04em;
            margin: 0;
        }

        .lightbox__pdf-button:hover {
            background: #b91c1c !important;
            box-shadow: 0 6px 16px rgba(220, 38, 38, 0.3) !important;
            transform: translateY(-1px);
        }
        .lightbox__pdf-button:active {
            transform: translateY(1px);
        }

        /* ---------- RESPONSIVE: Stack on Mobile ---------- */

        @media (max-width: 768px) {
            .lightbox__panel {
                flex-direction: column;
                width: 95vw;
                height: 92vh;
                max-height: none;
                border-radius: 14px;
                background: #ffffff;
            }

            .lightbox__image-side {
                flex: 0 0 45%;
                background: #ffffff;
            }

            .lightbox__image {
                padding: 16px 16px 36px !important;
                background-color: #ffffff !important;
            }

            .lightbox__nav {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: rgba(255, 255, 255, 0.72) !important;
                border: 1px solid rgba(0, 0, 0, 0.05) !important;
                color: #374151 !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            }

            .lightbox__nav--prev {
                left: 10px;
            }

            .lightbox__nav--next {
                right: 10px;
            }

            .lightbox__counter {
                bottom: 10px;
                font-size: 0.625rem;
                padding: 4px 10px;
            }

            .lightbox__info {
                flex: 1;
                border-left: none;
                border-top: 1px solid #eaeaea;
                background: linear-gradient(165deg, #fdfdfd 0%, #f5f6f8 100%);
            }

            .lightbox__info-inner {
                padding: 24px 20px 16px;
            }

            .lightbox__title {
                font-family: var(--font-display);
                font-size: 1.125rem;
                font-weight: 700;
            }

            .lightbox__divider {
                margin: 16px 0 14px;
            }

            .lightbox__description {
                font-family: var(--font-sans);
                font-size: 0.8125rem;
                line-height: 1.6;
            }

            .lightbox__info-footer {
                padding: 10px 20px;
            }
        }

        /* Responsive Mobile Chips Filter Styles */
        @media (max-width: 640px) {
            .filter-container {
                justify-content: center !important;
                width: 100%;
                padding: 0 16px;
                margin-bottom: 52px;
                overflow: visible;
            }
            
            .filter-bar {
                background: transparent;
                border: none;
                box-shadow: none;
                padding: 0 4px;
                border-radius: 0;
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
                gap: 8px;
                display: flex;
                margin: 0 auto;
                max-width: 100%;
                overflow-x: auto;
                scrollbar-width: none; /* Firefox */
                -webkit-overflow-scrolling: touch;
            }
            
            .filter-bar::-webkit-scrollbar {
                display: none; /* Safari/Chrome */
            }
            
            .filter-btn {
                background: rgba(255, 255, 255, 0.85) !important;
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                border: 1px solid rgba(0, 0, 0, 0.06) !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
                padding: 5px 12px;
                font-family: var(--font-display);
                font-size: 0.625rem;
                font-weight: 600;
                letter-spacing: 0.04em;
                flex-shrink: 0 !important;
                border-radius: 20px;
                color: var(--text-secondary);
            }
            
            .filter-btn.active {
                background: #166534 !important;
                border-color: #166534 !important;
                color: #FFFFFF !important;
                box-shadow: 0 4px 12px rgba(22, 101, 52, 0.2);
            }
        }
    </style>
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>
