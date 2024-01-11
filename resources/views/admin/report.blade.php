<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title }} Page</title>
  <meta name="description" content="" />
  <meta name="author" content="" />
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
  <style>
   body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.container {
  display: flex;
  width: 90%;
  margin: 0 auto;
}

.row1 {
  display: flex;
  flex-direction: row;
  width: 100%;
  justify-content: space-between;
}

.card {

      width: 140px;
      height: 130px;
      display: inline-block;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px;
      margin: 0 10px; 
      box-sizing: border-box;
}
.card2 {
  flex: 1;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 20px;
}
.card1 {
  flex: 1;
  border: none;
  padding: 20px;
  margin-bottom: 20px;
}
.ratings {
  color: #ffc107;
}

.rating-list {
  margin-bottom: 10px;
}

.progress-bar {
  height: 20px;
}

.reviews-members-header h6 {
  margin-bottom: 5px;
}

.reviews-members-body p {
  margin: 0;
}

</head>

<body>

  <div class="container">
    <div class="row1">
    <div class="card">
      <h2>Ratings and Reviews</h2>
      <div class="ratings">
        <?php
        $rating_sum = round($rate, 2);
        for ($i = 1; $i <= 5; $i++) {
          if ($i < $rating_sum) {
            echo '<i class="fa fa-star"></i>';
          } elseif ($i - 1 < $rating_sum && $rating_sum < $i) {
            echo '<i class="fa fa-star-half-stroke"></i>';
          } else {
            echo '<i class="fa fa-star-o"></i>';
          }
        }
        ?>
      </div>
      <p>Rated {{ round($rate, 2) }} out of 5</p>
    </div>

    <div class="card">
      <h2>Total Reviews</h2>
      <p><b>{{ $sum }}</b></p>
    </div>

    @if ($product_total != 0)
      <div class="card">
        <h2>Total Product</h2>
        <p><b>{{ $product_total }}</b></p>
      </div>
    @endif
    </div>

    <div class="card2">
      <h2>Ratings Breakdown</h2>
      <?php for ($star = 4; $star >= 0; $star--) : ?>
        <div class="rating-list">
          <div class="ratings">
            <?php
            $percentage = ($sum == 0) ? 0 : round($starCounter[$star] / $sum * 100);
            for ($i = 0; $i < 5; $i++) {
              echo ($i < $star + 1) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>';
            }
            ?>
          </div>
          <div class="progress-bar" style="width: <?= $percentage ?>%; background-color: #dc3545;"></div>
          <div class="text-black"><?= $percentage ?>%</div>
        </div>
      <?php endfor; ?>
    </div>

    <div class="card1">
      <h2>All Ratings and Reviews</h2>
      @if ($reviews != "[]")
      <?php foreach ($reviews as $review) : ?>
        <img style="width:80px; height:80px; margin-right:30px" alt="Generic placeholder image" src="{{ asset('storage/' . $review->user->image) }}"
      
          <div class="reviews-members">
            <div class="ratings">
              <?php
              $rating_sum = $review["rating"];
              for ($i = 0; $i < 5; $i++) {
                echo ($i < $rating_sum) ? '<i class="fa fa-star"></i>' : '<i class="fa fa-star-o"></i>';
              }
              ?>
            </div>
            <h6><a class="text-black" href="#"><?php $userID=$review->user_id;
                $result = App\Models\User::where('id',$userID)->value('username');
                echo $result;
              ?></a></h6>
            <small class="text-muted">{{ $review->created_at }}</small>
            <p>{{ $review->review }}</p>
            <?php if ($review->is_edit == 1) : ?>
              <small class="text-muted">Review has been edited at {{ $review->updated_at }}</small>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      @else
        <p class="link-grey">Oops, this product has no reviews for now.</p>
      @endif
    </div>

  </div>

  <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
</body>

</html>
