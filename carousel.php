<?php
  echo '<div id="post_'.$post_id.'" class="carousel slide" width="60%" data-bs-ride="carousel">
          <div class="carousel-indicators">';
  if($photo_1 != "" && $photo_1 != NULL)
    echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="0" class="active" aria-current="true" aria-labl="Slide 1"></button>';
  if($photo_2 != "" && $photo_2 != NULL)
    echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="1" aria-label="Slide 2"></button>';
  if($photo_3 != "" && $photo_3 != NULL)
    echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="2" aria-label="Slide 3"></button>';
  if($photo_4 != "" && $photo_4 != NULL)
    echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="3" aria-label="Slide 4"></button>';
  if($photo_5 != "" && $photo_5 != NULL)
    echo '  <button type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide-to="4" aria-label="Slide 5"></button>';
  echo '  </div>
          <div class="carousel-inner">';
  if($photo_1 != "" && $photo_1 != NULL)
    echo '  <div class="carousel-item active">
              <img src="./post_pictures/'.$photo_1.'" class="d-block w-100" alt="...">
            </div>';
  if($photo_2 != "" && $photo_2 != NULL)
    echo '  <div class="carousel-item">
              <img src="./post_pictures/'.$photo_2.'" class="d-block w-100" alt="...">
            </div>';
  if($photo_3 != "" && $photo_3 != NULL)
    echo '  <div class="carousel-item">
              <img src="./post_pictures/'.$photo_3.'" class="d-block w-100" alt="...">
            </div>';
  if($photo_4 != "" && $photo_4 != NULL)
    echo '  <div class="carousel-item">
              <img src="./post_pictures/'.$photo_4.'" class="d-block w-100" alt="...">
            </div>';
  if($photo_5 != "" && $photo_5 != NULL)
    echo '  <div class="carousel-item">
              <img src="./post_pictures/'.$photo_5.'" class="d-block w-100" alt="...">
            </div>';
  echo '  </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#post_'.$post_id.'" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>'

?>