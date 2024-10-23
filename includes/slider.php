<style>
  .carousel-item img {
    width: 100%;          /* Đảm bảo hình ảnh luôn chiếm hết chiều rộng của carousel */
    height: 500px;        /* Thiết lập chiều cao mong muốn */
    object-fit: contain;  /* Giúp hình ảnh thu nhỏ mà không bị cắt, giữ nguyên tỷ lệ */
  }
</style>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner" data-bs-interval="3000">
    <div class="carousel-item active">
      <img src="assets/images/sliderr-3.jpg" class="d-block w-100" alt="slider image">
    </div>
    <div class="carousel-item">
      <img src="assets/images/sliderr-2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/images/sliderr-1.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
