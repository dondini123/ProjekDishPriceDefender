<section id="hero" style="padding: 10px">
  <div class="container mt-0 mt-lg-5">
    <div class="row">
      <div class="col-md-6 pt-5 pt-lg-0 order-md-1 d-flex flex-column justify-content-center" data-aos="fade-up">
        <div>
          <h1>Spend wise, Eat Smart</h1>
          <p>A website that geared toward people that want to find the best offer of their dish everyday.</p>
          <a href="#about" class="btn-get-started scrollto">Get Started</a>
        </div>
      </div>
      <div class="col-md-6 order-md-2 mt-5 mt-lg-0 pt-5 pt-lg-0 d-none d-md-block hero-img" data-aos="fade-left">
        <img src="{{ asset('images/bgmakanan.jpg') }}" class="img-fluid" alt="FOOD">
      </div>
    </div>
  </div>

</section>

<main id="main">

  <!-- ======= About Section ======= -->
  <section id="about" class="about" style="padding: 10px">

    <div class="container" data-aos="fade-up">
      <div class="row">

        <div class="col-lg-5 col-md-6 d-none d-md-block">
          <div class="about-img" data-aos="fade-right" data-aos-delay="100">
            <img src="{{ asset('images/food heaven.jpg') }}" alt="DPD">
          </div>
        </div>

        <div class="col-lg-7 col-md-6">
          <div class="about-content" data-aos="fade-left" data-aos-delay="100">
            <h2>About DishPriceDefender</h2>
            <p>Dish Price Defender is an application that is dedicated to helping student
              in UTM to find the best price for dishes so that they can make their money goes the furthest.
              Helping the student in need is our priority and this application can help the best!!!</p>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section id="services" class="services section-bg">
    <div class="container">

      <div class="section-title" data-aos="fade-up">
        <h2>Additional Information</h2>
      </div>

      <div class="row">
        <div class="col-md-12 col-lg-6 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in">
          <div class="icon-box icon-box-pink">
            <div class="icon"><i class="fa fa-fw fa-dumpster"
                style="font-size: 48px;margin-bottom: 15px;line-height: 1;color:orange;"></i></div>
            <h4 class="title"><a href="">Why DishPriceDefender?</a></h4>
            <p class="description">Dish Price Defender is an easy to use application designed for UTM students to 
              find the best prices for dishes to avoid being overcharged as they will able to compare the prices 
              between food on each restaurant to find the best deal!!</p>
            
          </div>
        </div>

        <div class="col-md-12 col-lg-6 d-flex align-items-stretch mb-5 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
          <div class="icon-box icon-box-cyan">
            <div class="icon"><i class="fa fa-basket-shopping"
                style="font-size: 48px;margin-bottom: 15px;line-height: 1;color:#3fcdc7;"></i></div>

            <h4 class="title"><a href="">How to Use DishPriceDefender</a></h4>
            <p class="description"></p>
            <ol type ="1">
              <li>Choose The Shop U Want to See</li>
              <li>Choose The Item U Want to See</li>
              <li>Done!!!</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="product" class="pb-5">
    <div class="container">

        @if(session()->has('message'))
        {!! session("message") !!}
        @endif

        <h5 class="section-title h1">Shop</h5>
        @can('add_product',App\Models\Product::class)
        <div class="d-flex align-items-end flex-column mb-4">
            <a style="text-decoration: none;" href="/product/add_product">
                <div class="text-right button-kemren mr-lg-5 mr-sm-3">pe</div>
            </a>
        </div>
        @else
        <div class="mb-5"></div>
        @endcan

        <div class="row justify-content-center">
            @foreach($product as $row)
            <!-- Product card -->
            <div class="col-xs-12 col-sm-6 col-md-4">
               
                    <div class="mainflip">
                        <div class="frontside">
                            <div class="card">
                                <div class="card-body text-center">
                                    
                                    <h4 class="card-title">{{ $row->username }}</h4>
                                    
                                    <a href="/product/items/{{ $row->id}}"><button 
                                      class="btn btn-primary ">Product</button></a>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                
            </div>
            <!-- ./product card -->
            @endforeach
        </div>
    </div>
</section>


</main>