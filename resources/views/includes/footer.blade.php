

<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<!-- Import Js Files -->
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/theme/app.horizontal.init.js') }}"></script>
<script src="{{ asset('assets/js/theme/theme.js') }}"></script>
<script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
<script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/theme/feather.min.js') }}"></script>

<!-- solar icons -->


<script src="{{ asset('assets/libs/owl.carousel/dist/owl.carousel.min.js') }}"></script>
<script>
    $('.leadership-carousel').owlCarousel({
        //   loop: true,
        nav: true,
        dots: true,
        margin: 30,
        rtl: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            992: {
                items: 4
            },
            1024: {
                items: 5
            }
        },
        navText: ["<div class='btn btn-primary mx-2'>السابق</div>",
            "<div class='btn btn-primary mx-2'>التالي</div>"
        ],

    });
    $('.owl-carousel').find('.owl-nav').removeClass('disabled');

    function showError(input, message) {
        const errorDiv = document.createElement("div");
        errorDiv.className = "error-message text-danger";
        errorDiv.textContent = message;
        input.closest(".form-group").appendChild(errorDiv);
    }

</script>



<!-- solar icons -->

<script src="{{ asset('assets/js/iconify-icon.min.js') }}"></script>
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable.init.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-advanced.init.js') }}"></script>


</body>




</html>
