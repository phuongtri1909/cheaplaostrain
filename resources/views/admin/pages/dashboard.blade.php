@extends('admin.layouts.app')

@push('styles-admin')
<style>
    .feature-card {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
        height: 100%;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .feature-icon {
        font-size: 2rem;
        color: #369694;
    }

    .card-category {
        border-left: 4px solid #369694;
        padding-left: 10px;
        margin-bottom: 20px;
        font-weight: 600;
        color: #333;
    }
</style>
@endpush

@section('content-auth')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Bảng điều khiển</h2>
                <p class="text-muted">Chào mừng đến với trang quản trị</p>
                @include('components.toast')
            </div>
        </div>

        <!-- Stats Summary Row -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card bg-gradient-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 text-white">Bài viết</h5>
                                <p class="mb-0">{{ \App\Models\Blog::count() }}</p>
                            </div>
                            <div class="rounded-circle bg-white p-2">
                                <i class="fa-regular fa-message text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card bg-gradient-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 text-white">Câu hỏi thường gặp</h5>
                                <p class="mb-0">{{ \App\Models\Faq::count() }}</p>
                            </div>
                            <div class="rounded-circle bg-white p-2">
                                <i class="fa-solid fa-question text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card bg-gradient-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 text-white">Danh mục FAQ</h5>
                                <p class="mb-0">{{ \App\Models\FaqCategory::count() }}</p>
                            </div>
                            <div class="rounded-circle bg-white p-2">
                                <i class="fa-solid fa-folder text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Management -->
        <h4 class="card-category">Quản lý nội dung</h4>
        <div class="row mb-5">

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fa-solid fa-question feature-icon mb-3"></i>
                        <h5 class="card-title">Câu hỏi thường gặp</h5>
                        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-primary">Quản lý</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fa-solid fa-folder feature-icon mb-3"></i>
                        <h5 class="card-title">Danh mục FAQ</h5>
                        <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-outline-primary">Quản lý</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fa-regular fa-message feature-icon mb-3"></i>
                        <h5 class="card-title">Bài viết</h5>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-primary">Quản lý</a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Website Elements -->
        <h4 class="card-category">Thành phần website</h4>
        <div class="row">

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fa-solid fa-globe feature-icon mb-3"></i>
                        <h5 class="card-title">Mạng xã hội</h5>
                        <a href="{{ route('admin.socials.index') }}" class="btn btn-outline-primary">Quản lý</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fa-regular fa-image feature-icon mb-3"></i>
                        <h5 class="card-title">Banner</h5>
                        <a href="{{ route('admin.banner-home.index') }}" class="btn btn-outline-primary">Quản lý</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Settings -->
        <h4 class="card-category mt-4">Cài đặt hệ thống</h4>
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fa-solid fa-language feature-icon mb-3"></i>
                        <h5 class="card-title">Quản lý ngôn ngữ</h5>
                        <p class="card-text text-muted">Quản lý cài đặt ngôn ngữ và bản dịch</p>
                        <a href="{{ route('admin.languages.index') }}" class="btn btn-outline-primary">Quản lý</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 mb-4">
                <div class="card feature-card shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="fa-solid fa-users feature-icon mb-3"></i>
                        <h5 class="card-title">Danh sách tài khoản</h5>
                        <p class="card-text text-muted">Quản lý tài khoản người dùng và quyền hạn</p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">Quản lý</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
