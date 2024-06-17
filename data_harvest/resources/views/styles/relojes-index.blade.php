
<style>
    #main-styles {
    margin: 0;
    padding: 0;
    background-image: url('{{asset("img/mis-relojes.fondo.jpg")}}') !important;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
}
.custom-clock-icon {
            font-size: 48px;
            color: rgb(254,201,1);
        }

</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


<link href="{{ asset('css/vendor.min.css') }}" rel="stylesheet" />
<link href="{{ asset('css/default/app.min.css') }}" rel="stylesheet" />
<!-- ================== END core-css ================== -->

<!-- ================== BEGIN page-css ================== -->
<link href="{{ asset('plugins/lightbox2/dist/css/lightbox.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


<style>


.custom-btn {
    background-color: rgb(41, 81, 155);
    color: white;
    border: none;
    padding: 4%;
    text-align: center;
    width: fit-content;
    text-decoration: none;
    cursor: pointer;
    border-radius: 4px;
}

.custom-btn:hover {
    background-color:rgb(147, 185, 236);
    color: white;

}
.eliminar-reloj{
    background-color: rgb(207, 42, 42);;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    border-radius: 4px;
}
.eliminar-reloj:hover{
    background-color:rgb(155, 2, 2);
    color: white;
}





</style>
