@extends('layouts.app')

@section('title', 'Frequently Asked Questions')
@section('description', 'Find answers to commonly asked questions and get detailed information')
@section('keywords', 'FAQ, frequently asked questions, customer support')

@push('styles')
<style>
    .faq-hero {
        background: var(--gradient-green);
        color: white;
        padding: 50px 0 35px 0;
        position: relative;
        overflow: hidden;
    }

    .faq-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>') no-repeat center center;
        background-size: cover;
    }

    .faq-hero h1 {
        font-size: 2.4rem;
        font-weight: 700;
        margin-bottom: 0.4rem;
        animation: fadeInUp 1s ease-out;
    }

    .faq-hero p {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 0;
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .search-box {
        background: var(--glass-bg);
        border-radius: var(--radius-xl);
        padding: 4px;
        box-shadow: var(--shadow-medium);
        margin-top: 1.2rem;
        animation: fadeInUp 1s ease-out 0.4s both;
        max-width: 450px;
        margin-left: auto;
        margin-right: auto;
    }

    .search-input {
        border: none;
        outline: none;
        padding: 8px 16px;
        border-radius: var(--radius-xl);
        font-size: 0.9rem;
        width: 100%;
        background: transparent;
        color: var(--text-dark);
    }

    .search-input::placeholder {
        color: var(--text-light);
    }

    .search-btn {
        background: var(--gradient-green);
        border: none;
        color: white;
        padding: 8px 16px;
        border-radius: var(--radius-xl);
        cursor: pointer;
        transition: var(--transition-smooth);
        min-width: 45px;
    }

    .search-btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow-soft);
    }

    .faq-container {
        padding: 50px 0;
        background: var(--soft-gray);
    }

    /* Category Selector */
    .category-selector {
        margin-bottom: 2.5rem;
        text-align: center;
    }

    .category-select-wrapper {
        position: relative;
        display: inline-block;
        max-width: 300px;
        width: 100%;
    }

    .category-select {
        width: 100%;
        padding: 12px 45px 12px 20px;
        background: var(--warm-white);
        border: 2px solid var(--accent-green);
        border-radius: var(--radius-lg);
        font-size: 0.95rem;
        font-weight: 500;
        color: var(--text-dark);
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        outline: none;
        transition: var(--transition-smooth);
        box-shadow: var(--shadow-soft);
    }

    .category-select:focus {
        border-color: var(--primary-green);
        box-shadow: var(--shadow-medium);
    }

    .category-select:hover {
        border-color: var(--primary-green);
    }

    .category-select-wrapper::after {
        content: '\f107';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
        color: var(--primary-green);
        font-size: 1.1rem;
    }

    .category-label {
        display: block;
        font-size: 0.9rem;
        color: var(--text-medium);
        margin-bottom: 8px;
        font-weight: 500;
    }

    .faq-category {
        margin-bottom: 2.5rem;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .category-header {
        background: var(--warm-white);
        padding: 1.2rem 1.5rem;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-soft);
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--primary-green);
    }

    .category-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .category-icon {
        width: 30px;
        height: 30px;
        background: var(--gradient-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .faq-accordion {
        background: var(--warm-white);
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-soft);
    }

    .faq-item {
        border-bottom: 1px solid var(--accent-green);
    }

    .faq-item:last-child {
        border-bottom: none;
    }

    .faq-question {
        width: 100%;
        background: none;
        border: none;
        padding: 1.2rem 1.5rem;
        text-align: left;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        transition: var(--transition-smooth);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .faq-question:hover {

    }

    .faq-question.active {

    }

    .faq-toggle {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: var(--soft-gray);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-smooth);
        font-size: 1rem;
        color: var(--text-medium);
    }

    .faq-question.active .faq-toggle {
        background: rgba(255,255,255,0.2);
        color: white;
        transform: rotate(180deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: var(--transition-slow);
    }

    .faq-answer.show {
        max-height: 500px;
    }

    .faq-answer-content {
        padding: 1.2rem 1.5rem;
        color: var(--text-medium);
        line-height: 1.6;
        font-size: 0.95rem;
    }

    .search-results {
        background: var(--warm-white);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-soft);
        margin-bottom: 2rem;
        display: none;
    }

    .search-results.show {
        display: block;
        animation: fadeInUp 0.4s ease-out;
    }

    .search-result-item {
        padding: 1.2rem 1.5rem;
        border-bottom: 1px solid var(--accent-green);
        cursor: pointer;
        transition: var(--transition-smooth);
    }

    .search-result-item:hover {
        background: var(--accent-green);
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-question {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.4rem;
        font-size: 0.95rem;
    }

    .search-result-category {
        font-size: 0.8rem;
        color: var(--primary-green);
        background: var(--accent-green);
        padding: 3px 10px;
        border-radius: var(--radius-md);
        display: inline-block;
    }

    .no-results {
        text-align: center;
        padding: 2.5rem;
        color: var(--text-medium);
    }

    .no-results i {
        color: var(--text-light) !important;
    }

    .no-results h3 {
        color: var(--text-dark);
        margin-bottom: 0.8rem;
        font-size: 1.3rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .faq-hero {
            padding: 35px 0 25px 0;
        }

        .faq-hero h1 {
            font-size: 2rem;
        }

        .faq-hero p {
            font-size: 0.9rem;
        }

        .search-box {
            margin-top: 1rem;
            max-width: 100%;
        }

        .category-select-wrapper {
            max-width: 100%;
        }

        .category-select {
            font-size: 0.9rem;
            padding: 10px 40px 10px 16px;
        }

        .faq-question {
            padding: 1rem 1.2rem;
            font-size: 0.95rem;
        }

        .faq-answer-content {
            padding: 1rem 1.2rem;
            font-size: 0.9rem;
        }

        .category-header {
            padding: 1rem 1.2rem;
        }

        .category-title {
            font-size: 1.1rem;
        }

        .category-icon {
            width: 26px;
            height: 26px;
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="faq-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Frequently Asked Questions</h1>
                <p>Find answers to common questions and get the help you need</p>

                <!-- Search Box -->
                <div class="search-box">
                    <div class="d-flex align-items-center">
                        <input type="text" id="faqSearch" class="search-input"
                               placeholder="Search questions...">
                        <button type="button" class="search-btn" onclick="searchFAQs()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Content -->
<div class="faq-container">
    <div class="container">
        <!-- Search Results -->
        <div id="searchResults" class="search-results">
            <div class="search-results-content">
                <!-- Results will be loaded here -->
            </div>
        </div>

        <!-- Category Selector -->
        <div class="category-selector">
            <label class="category-label">
                <i class="fas fa-filter"></i> Filter by Category
            </label>
            <div class="category-select-wrapper">
                <select id="categorySelect" class="category-select">
                    <option value="all">All Categories ({{ $totalFaqs }} questions)</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->name }} ({{ $category->faqs->count() }} questions)
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- FAQ Categories -->
        <div id="faqContent">
            @foreach($categories as $categoryIndex => $category)
                @if($category->faqs->count() > 0)
                    <div class="faq-category" data-category="{{ $category->id }}"
                         style="animation-delay: {{ $categoryIndex * 0.1 }}s">

                        <!-- Category Header -->
                        <div class="category-header">
                            <h2 class="category-title">
                                <div class="category-icon">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                {{ $category->name }}
                            </h2>
                        </div>

                        <!-- FAQ Accordion -->
                        <div class="faq-accordion">
                            @foreach($category->faqs as $faqIndex => $faq)
                                <div class="faq-item">
                                    <button class="faq-question" type="button"
                                            onclick="toggleFAQ(this)">
                                        <span>{{ $faq->question }}</span>
                                        <div class="faq-toggle">
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </button>
                                    <div class="faq-answer">
                                        <div class="faq-answer-content">
                                            {!! $faq->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            @if($categories->isEmpty() || $totalFaqs == 0)
                <div class="no-results">
                    <i class="fas fa-question-circle fa-3x mb-3 text-muted"></i>
                    <h3>No Questions Available</h3>
                    <p>There are currently no frequently asked questions available.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle FAQ Answer
    function toggleFAQ(button) {
        const answer = button.nextElementSibling;
        const isOpen = answer.classList.contains('show');

        // Close all other FAQs in the same category
        const category = button.closest('.faq-category');
        category.querySelectorAll('.faq-question.active').forEach(q => {
            if (q !== button) {
                q.classList.remove('active');
                q.nextElementSibling.classList.remove('show');
            }
        });

        // Toggle current FAQ
        if (isOpen) {
            button.classList.remove('active');
            answer.classList.remove('show');
        } else {
            button.classList.add('active');
            answer.classList.add('show');
        }
    }

    // Category Filter via Select
    document.getElementById('categorySelect').addEventListener('change', function() {
        const categoryId = this.value;

        // Hide search results
        document.getElementById('searchResults').classList.remove('show');

        // Show/hide categories
        document.querySelectorAll('.faq-category').forEach(category => {
            if (categoryId === 'all' || category.dataset.category === categoryId) {
                category.style.display = 'block';
                // Re-trigger animation
                category.style.animation = 'none';
                setTimeout(() => {
                    category.style.animation = 'fadeInUp 0.6s ease-out forwards';
                }, 10);
            } else {
                category.style.display = 'none';
            }
        });
    });

    // Search FAQs
    let searchTimeout;
    document.getElementById('faqSearch').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            document.getElementById('searchResults').classList.remove('show');
            document.getElementById('faqContent').style.display = 'block';
            return;
        }

        searchTimeout = setTimeout(() => {
            searchFAQs(query);
        }, 300);
    });

    function searchFAQs(query = null) {
        if (!query) {
            query = document.getElementById('faqSearch').value.trim();
        }

        if (query.length < 2) return;

        fetch(`{{ route('faqs.search') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data, query);
            })
            .catch(error => {
                console.error('Search error:', error);
            });
    }

    function displaySearchResults(results, query) {
        const searchResultsDiv = document.getElementById('searchResults');
        const faqContent = document.getElementById('faqContent');
        const resultsContent = searchResultsDiv.querySelector('.search-results-content');

        if (results.length === 0) {
            resultsContent.innerHTML = `
                <div class="no-results">
                    <i class="fas fa-search fa-3x mb-3 text-muted"></i>
                    <h3>No Results Found</h3>
                    <p>No questions match your search for "<strong>${query}</strong>"</p>
                </div>
            `;
        } else {
            let html = `<div style="padding: 1.2rem 1.5rem; border-bottom: 1px solid var(--accent-green);">
                           <h4 style="margin: 0; color: var(--text-dark); font-size: 1.1rem;">Search results for: "<span style="color: var(--primary-green);">${query}</span>"</h4>
                           <small style="color: var(--text-medium);">Found ${results.length} result${results.length > 1 ? 's' : ''}</small>
                       </div>`;

            results.forEach(faq => {
                html += `
                    <div class="search-result-item" onclick="scrollToFAQ(${faq.id})">
                        <div class="search-result-question">${highlightText(faq.question, query)}</div>
                        <span class="search-result-category">${faq.faq_category.name}</span>
                    </div>
                `;
            });

            resultsContent.innerHTML = html;
        }

        searchResultsDiv.classList.add('show');
        faqContent.style.display = 'none';
    }

    function highlightText(text, query) {
        const regex = new RegExp(`(${query})`, 'gi');
        return text.replace(regex, '<mark style="background: var(--cream); padding: 2px 4px; border-radius: 3px; color: var(--primary-green-dark);">$1</mark>');
    }

    function scrollToFAQ(faqId) {
        // Clear search and show all content
        document.getElementById('faqSearch').value = '';
        document.getElementById('searchResults').classList.remove('show');
        document.getElementById('faqContent').style.display = 'block';

        // Reset category select to show all
        document.getElementById('categorySelect').value = 'all';
        document.getElementById('categorySelect').dispatchEvent(new Event('change'));

        // Find and open the specific FAQ
        setTimeout(() => {
            const faqButtons = document.querySelectorAll('.faq-question');
            faqButtons.forEach(button => {
                const faqItem = button.closest('.faq-item');
                if (faqItem && faqItem.dataset.faqId == faqId) {
                    button.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    setTimeout(() => {
                        if (!button.classList.contains('active')) {
                            toggleFAQ(button);
                        }
                        // Highlight effect
                        button.style.background = 'var(--cream)';
                        setTimeout(() => {
                            button.style.background = '';
                        }, 2000);
                    }, 500);
                }
            });
        }, 100);
    }

    // Add FAQ ID to items for search functionality
    document.addEventListener('DOMContentLoaded', function() {
        let faqIndex = 1;
        document.querySelectorAll('.faq-item').forEach(item => {
            item.dataset.faqId = faqIndex++;
        });
    });
</script>
@endpush
