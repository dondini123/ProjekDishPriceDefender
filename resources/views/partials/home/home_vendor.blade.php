
    <h1 class="mt-2">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
          
                    <select class="form-select bg-secondary border border-secondary text-white" aria-label="Select Product" onchange="window.location.href = this.value;">
                        <option class="bg-light text-black" selected>Select Product</option>
                        <option class='bg-light text-black' value="/home/vendor">All</option>
                                @foreach($product as $item)
                               <option class='bg-light text-black' value="/home/vendor/{{$item->id}}">{{ $item -> product_name}}</option>
                                @endforeach
                    </select>
        
        </div>
       
    </div>

  <div class="row mb-4">
    <div class="col-xl-4 col-md-6">
            <div class="card bg-warning text-black mb-4 p-4">           
                        <h5 class="mb-0 mb-4">Ratings and Reviews</h5>
                        <div class="graph-star-rating-header">
                            <div class="ratings">
                                <?php
                                $rating_sum = round($rate, 2);
                                for ($i = 1; $i <= 5; $i++) {
                                if ($i < $rating_sum) {
                                    echo '<i class="fa fa-star rating-color"></i>';
                                } else if ($i - 1 < $rating_sum && $rating_sum < $i) {
                                    echo '<i class="fa fa-star-half-stroke rating-color"></i>';
                                } else {
                                    echo '<i class="fa fa-star"></i>';
                                }
                                }
                                ?>
                            </div>
                        <p class="text-black mb-4 mt-2">Rated
                            {{ round($rate, 2) }} out of 5
                        </p>
                        </div>                 
            </div>
        </div>


        <div class="col-xl-4 col-md-6">
            <div class="card bg-info text-black mb-4 p-4">
               
            <h5 class="mb-0 mb-4">Total Reviews</h5>
                        <div class="graph-star-rating-header">

                        <p class="text-black mb-4 mt-2">
                            <b>{{ $sum}}</b>
                        </p>
                        </div>

                        <p class="text-black mb-3 mt-2">
                        </p>
            </div>
        </div>

        @if($product_total != 0)
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white mb-4 p-4">
               
            <h5 class="mb-0 mb-4">Total Product</h5>
                        <div class="graph-star-rating-header">

                        <p class="text-white mb-4 mt-2">
                            <b>{{ $product_total}}</b>
                        </p>
                        </div>

                        <p class="text-black mb-3 mt-2">
                        </p>
            </div>
        </div>

        </div>
         @endif



            <div class="graph-star-rating-body mb-2">
              @for ($star = 4; 0 <= $star; $star--) 
              <div class="rating-list mb-2">
                <div class="rating-list-left text-black">
                  {{ $star + 1 }} Star
                </div>
                <div class="row">
                    <div class="col-11">
                <div class="rating-list-center">
                  <div class="progress col-10">
                    <div style="width: {{ ($sum == 0) ? 0 : $starCounter[$star] / $sum * 100 }}%"
                      aria-valuemax="{{ $star }}" aria-valuemin="0" aria-valuenow="<?= $star; ?>" role="progressbar"
                      class="progress-bar bg-danger">
                    </div>
                  </div>
                </div>
                <div class="rating-list-right text-black">
                  {{ ($sum == 0) ? 0 : round($starCounter[$star] / $sum * 100) }}%
                </div>
                </div>
                </div>
            </div>
            
            @endfor
            </div>

             <!-- Reply rating dan review dari user -->
    <div class="bg-white rounded shadow-sm p-4 mb-4 restaurant-detailed-ratings-and-reviews">
          <div class="d-flex justify-content-between">
            <h5 class="mb-1">All Ratings and Reviews</h5>
            <a href="#" class="btn btn-outline-secondary btn-sm float-end">Scroll to Rating</a>
          </div>
          <div class="reviews-members pt-4 pb-4">

            @if ($reviews != "[]")
            <!-- content review -->
            <?php foreach ($reviews as $review) : ?>
            <div class="media d-flex">
              <a href="#"><img style="width:80px; height:80px; margin-right:30px" alt="Generic placeholder image" src="{{ asset('images/profile.png') }}"
                  class="mr-3 mt-3 rounded-pill"></a>
              <div class="media-body w-100">
                <div class="d-flex justify-content-between align-items center">
                  <div class="reviews-members-header">
                    <!-- star reviews -->
                    <div class="ratings">
                      <?php
                      $rating_sum = $review["rating"];
                      for ($i = 0; $i < 5; $i++) {
                        if ($i < $rating_sum) {
                          echo '<i class="fa fa-star rating-color" style="font-size:  0.75rem;"></i>';
                        } else {
                          echo '<i class="fa fa-star" style="font-size: 0.75rem;"></i>';
                        }
                      }
                      ?>
                    </div>
                    <h6 class="my-1"><a class="text-black" href="#">
                        {{ $review->user->username }}
                      </a></h6>
                    <small>
                      <p class="text-muted">
                        {{ $review->created_at }}
                      </p>
                    </small>
                  </div>
                </div>
                <div class="reviews-members-body">
                  <p>
                    {{ $review->review }}
                  </p>
                </div>
                <?php if ($review->is_edit == 1) : ?>
                <div class="w-100 d-flex justify-content-end">
                  <small class="text-muted">Review has been edited at {{ $review->updated_at }}</small>
                </div>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
            @else
            <p class="link-grey">Oops, this product has no reviews for now.</p>
            @endif
          </div>
        </div>

