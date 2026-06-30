<div id="page-loader">
    <div class="loader"></div>
</div>

<style>
#page-loader{
    position:fixed;
    inset:0;
    background:#f4f7fb;
    display:flex;
    align-items:center;
    justify-content:center;
    z-index:9999999;
}

.loader{
    width:40px;
    height:40px;
    border:4px solid #dbeafe;
    border-top-color:#2563eb;
    border-radius:50%;
    animation:spin .7s linear infinite;
}

@keyframes spin{
    to{ transform:rotate(360deg); }
}
</style>

<script>
window.addEventListener("load", function () {
    const loader = document.getElementById("page-loader");
    if(loader){
        loader.style.display = "none";
    }
});
</script>