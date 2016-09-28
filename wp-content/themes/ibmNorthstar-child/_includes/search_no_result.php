<div class="search-no-result-container">
  <div class="search-no-result-wrapper post">
    <div class="icon-wrapper">
      <svg width="89px" height="89px" viewBox="20 14 89 89" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <!-- Generator: Sketch 39.1 (31720) - http://www.bohemiancoding.com/sketch -->
        <desc>Created with Sketch.</desc>
        <defs></defs>
        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" transform="translate(21.000000, 15.000000)">
            <path d="M33.9215208,0.173520833 C15.2827708,0.173520833 0.172979167,15.2833125 0.172979167,33.9220625 C0.172979167,52.5608125 15.2827708,67.6733125 33.9215208,67.6733125 C52.5629792,67.6733125 67.6727708,52.5608125 67.6727708,33.9220625 C67.6727708,15.2833125 52.5629792,0.173520833 33.9215208,0.173520833 Z" id="Stroke-1" stroke="#747474" stroke-width="2.28271701" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M57.79575,57.7952083 L86.07075,86.0702083" id="Stroke-3" stroke="#747474" stroke-width="2.28271701" stroke-linecap="round" stroke-linejoin="round"></path>
            <path d="M31.2910602,29.3308958 C31.2910602,28.3938125 30.5327269,27.6354792 29.5956435,27.6354792 C28.6585602,27.6354792 27.8975185,28.3938125 27.8975185,29.3308958 C27.8975185,30.2679792 28.6585602,31.0263125 29.5956435,31.0263125 C30.5327269,31.0263125 31.2910602,30.2679792 31.2910602,29.3308958" id="Fill-5" fill="#747474"></path>
            <path d="M44.8565602,29.3308958 C44.8565602,28.3938125 44.0982269,27.6354792 43.1611435,27.6354792 C42.2240602,27.6354792 41.4630185,28.3938125 41.4630185,29.3308958 C41.4630185,30.2679792 42.2240602,31.0263125 43.1611435,31.0263125 C44.0982269,31.0263125 44.8565602,30.2679792 44.8565602,29.3308958" id="Fill-7" fill="#747474"></path>
            <path d="M43.1600602,40.7451667 C43.1600602,36.9995417 40.1240185,33.9635 36.3783935,33.9635 C32.6300602,33.9635 29.5940185,36.9995417 29.5940185,40.7451667" id="Stroke-9" stroke="#747474" stroke-width="2.28220947" stroke-linecap="round"></path>
        </g>
      </svg>
    </div>
    <div class="title">
      <p class="ibm-h2">
        We couldn't find what you were looking for.  
      </p>
    </div>
    <div class="description">
      <p>
        Here are some search tips to broaden your search
      </p>
      <?php
        $temp = array();
        foreach($_GET as $key => $value){
          if($key === "s"){
            array_push($temp, "q=".$value);
          }
          else {
            array_push($temp, $key."=".$value);  
          }
        }
      ?>
      <ul>
        <li>Check spelling</li>
        <li>Broaden your search terms</li>
        <li>Try out your <a target="_blank" href="https://www.ibm.com/Search/?<?php echo implode('&', $temp); ?>" style="color:#4178BE;">search on ibm.com</a></li>
      </ul>
    </div>
  </div>

</div>