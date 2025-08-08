//hidden password

$(document).on('click', '#togglePassword', function () {
    const passwordField = $('#password')
    const type = passwordField.attr('type') === 'password' ? 'text' : 'password'
    passwordField.attr('type', type)

    $(this).toggleClass('fa-eye fa-eye-slash')
})

//hidden password confirm

$(document).on('click', '#togglePasswordConfirm', function () {
    const passwordField = $('#password_confirmation')
    const type = passwordField.attr('type') === 'password' ? 'text' : 'password'
    passwordField.attr('type', type)

    $(this).toggleClass('fa-eye fa-eye-slash')
})

//toast
function showToast (message, status) {
    const toastElement = $('#liveToast')
    const toastBody = toastElement.find('.toast-body')

    // Cập nhật nội dung tin nhắn
    toastBody.text(message)

    // Xóa các lớp nền cũ
    toastElement.removeClass('bg-success bg-danger text-white')

    // Thêm lớp nền dựa trên trạng thái
    if (status === 'success') {
        toastElement.addClass('bg-success text-white')
    } else if (status === 'error') {
        toastElement.addClass('bg-danger text-white')
    }

    // Hiển thị toast
    const toast = new bootstrap.Toast(toastElement[0])
    toast.show()
}

//save toast

function saveToast (message, status) {
    sessionStorage.setItem('toastMessage', message)
    sessionStorage.setItem('toastStatus', status)
}

//show toast
function showSavedToast () {
    const message = sessionStorage.getItem('toastMessage')
    const status = sessionStorage.getItem('toastStatus')

    if (message && status) {
        showToast(message, status)
        sessionStorage.removeItem('toastMessage')
        sessionStorage.removeItem('toastStatus')
    }
}

//otp

function handleInput (element) {
    $(element).val(
        $(element)
            .val()
            .replace(/[^0-9]/g, '')
    )

    if ($(element).val().length === 1) {
        const nextInput = $(element).next('.otp-input')
        if (nextInput.length) {
            nextInput.focus()
        }
    }
}

// Lưu vị trí cuộn trang khi chuyển trang
$(document).ready(function () {
    $('.click-scroll').on('click', function (e) {
        localStorage.setItem('scrollPosition', $(window).scrollTop())
        window.location.href = $(this).attr('href')
    })

    const scrollPosition = localStorage.getItem('scrollPosition')
    if (scrollPosition) {
        $(window).scrollTop(scrollPosition)
        localStorage.removeItem('scrollPosition')
    }
})
// Lưu vị trí cuộn trang khi chuyển trang

// Sticky Header
$(document).ready(function () {
    function handleStickyHeader () {
        const header = $('#siteHeader')
        const scrollPosition = $(window).scrollTop()

        if (scrollPosition > 100) {
            header.addClass('sticky')
        } else {
            header.removeClass('sticky')
        }
    }

    // Initial check
    handleStickyHeader()

    // Check on scroll
    $(window).on('scroll', function () {
        handleStickyHeader()
    })

    // Language switcher
    $('.dropdown-item[data-lang]').on('click', function (e) {
        e.preventDefault()
        const lang = $(this).data('lang')
        // Here you can implement the logic to switch language
        // This is just a placeholder that updates the button text
        if (lang === 'en') {
            $('#languageDropdown').html('<i class="fas fa-globe me-1"></i> EN')
        } else if (lang === 'vi') {
            $('#languageDropdown').html('<i class="fas fa-globe me-1"></i> VI')
        }
        // Actual language switching would typically involve a page reload or AJAX call
    })
})

// Mobile menu dropdown handling
$(document).ready(function () {
    // Xử lý hover trên desktop
    if (window.innerWidth >= 992) {
        $('.hover-dropdown').hover(
            function () {
                $(this).find('.dropdown-menu').addClass('show')
            },
            function () {
                $(this).find('.dropdown-menu').removeClass('show')
            }
        )
    }

    // Ngăn việc chuyển hướng khi click vào nút toggle
    $('.mobile-dropdown-toggle').on('click', function (e) {
        e.preventDefault()
        e.stopPropagation()

        // Toggle dropdown menu
        const dropdownMenu = $(this)
            .closest('.hover-dropdown')
            .find('.dropdown-menu')

        // Đóng các menu khác
        $('.dropdown-menu').not(dropdownMenu).removeClass('show')

        // Toggle menu hiện tại
        dropdownMenu.toggleClass('show')

        // Thay đổi icon
        const icon = $(this).find('i')
        if (icon.hasClass('fa-chevron-down')) {
            icon.removeClass('fa-chevron-down').addClass('fa-chevron-up')
        } else {
            icon.removeClass('fa-chevron-up').addClass('fa-chevron-down')
        }
    })

    // Đóng tất cả dropdown khi nhấp ra ngoài
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.hover-dropdown').length) {
            $('.dropdown-menu').removeClass('show')
            $('.mobile-dropdown-toggle i')
                .removeClass('fa-chevron-up')
                .addClass('fa-chevron-down')
        }
    })

    // Xử lý thay đổi kích thước window
    $(window).on('resize', function () {
        if (window.innerWidth >= 992) {
            $('.dropdown-menu').removeClass('show')
        }
    })
})

// dropdown language
document.addEventListener('DOMContentLoaded', function() {
    const languageToggle = document.getElementById('languageToggle');
    const languageDropdown = document.getElementById('languageDropdown');
    
    if (languageToggle && languageDropdown) {
        // Toggle dropdown when clicking on the language selector
        languageToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            languageToggle.classList.toggle('active');
            languageDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!languageToggle.contains(e.target) && !languageDropdown.contains(e.target)) {
                languageToggle.classList.remove('active');
                languageDropdown.classList.remove('show');
            }
        });
        
        // Prevent dropdown from closing when clicking inside it
        languageDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
});
