@extends('client.share.master')
@section('content')
<!-- ========== PAGE TITLE ========== -->
<div class="page-title gradient-overlay op5" style="background: url(images/breadcrumb.jpg); background-repeat: no-repeat;
background-size: cover;">
    <div class="container">
      <div class="inner">
        <h1>SINGLE ROOM</h1>
        <div class="room-details-price">
          €89 / NIGHT
        </div>
        <ol class="breadcrumb">
          <li>
            <a href="index.html">Home</a>
          </li>
          <li>
            <a href="index.html">Rooms</a>
          </li>
          <li>Single Room</li>
        </ol>
      </div>
    </div>
</div>

<main class="room">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 col-12">
          <!-- ROOM SLIDER -->
          <div class="room-slider">
            <div id="room-main-image" class="owl-carousel image-gallery">
                @php
                    $hinh_anh = explode(",", $data->hinh_anh);
                @endphp
                @foreach ($hinh_anh as $key => $value)
                <div class="item">
                    <figure class="gradient-overlay-hover image-icon">
                    <a href="{{ $value }}">
                        <img class="img-fluid" src="{{ $value }}" alt="Image">
                    </a>
                    </figure>
                </div>
                @endforeach
            </div>
            <div id="room-thumbs" class="room-thumbs owl-carousel">
                @foreach ($hinh_anh as $key => $value)
                    <div class="item"><img class="img-fluid" src="{{ $value }}" alt="Image"></div>
                @endforeach
            </div>
          </div>
          <p class="dropcap" style="text-align: justify">
            {!! $data->mo_ta_phong !!}
          </p>
          <div class="similar-rooms">
            <div class="section-title sm">
              <h4>SIMILAR ROOMS</h4>
              <p class="section-subtitle">Leave your review</p>
            </div>
            <div class="row">
                @foreach ($list as $k => $v)
                    @php
                        $hinh_anh = explode(",", $v->hinh_anh);
                        // dd($hinh_anh);
                        if(count($hinh_anh) > 0 && $hinh_anh[0] != "") {
                            $hinh_anh = $hinh_anh[0];
                        } else {
                            $hinh_anh = 'https://d2e5ushqwiltxm.cloudfront.net/wp-content/uploads/sites/86/2018/12/18031433/deluxe-king-bed-room-cottage-at-pullman-danang-beach-resort-vietnam-5-star-hotel.jpg';
                        }
                    @endphp
                    <div class="col-lg-4">
                        <div class="room-grid-item">
                        <figure class="gradient-overlay-hover link-icon">
                            <a href="room.html">
                            <img src="{{ $hinh_anh }}" class="img-fluid" alt="Image">
                            </a>
                            <div class="room-services">
                            <i class="fa fa-coffee" aria-hidden="true" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Breakfast Included" data-original-title="Breakfast"></i>
                            <i class="fa fa-wifi" aria-hidden="true" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Free WiFi" data-original-title="WiFi"></i>
                            <i class="fa fa-television" data-toggle="popover" data-placement="right" data-trigger="hover" data-content="Plasma TV with cable channels" data-original-title="TV"></i>
                            </div>
                            <div class="room-price">{{ number_format($v->gia_mac_dinh, 0, ',', '.') }} đ/ night</div>
                        </figure>
                        <div class="room-info">
                            <h2 class="room-title">
                            <a href="room.html">{{ $v->ma_phong }}</a>
                            </h2>
                            <p>Enjoy our {{ $v->ma_phong }}</p>
                        </div>
                        </div>
                    </div>
                @endforeach
            </div>
          </div>
        </div>
        <!-- SIDEBAR -->
        <div class="col-lg-3 col-12">
          <div class="sidebar">
            <!-- WIDGET -->
            <aside class="widget noborder">
              <div class="vertical-booking-form">
                <div id="booking-notification" class="notification"></div>
                <h3 class="form-title">BOOK YOUR ROOM</h3>
                <div class="inner">
                  <form id="booking-form">
                    <!-- EMAIL -->
                    <div class="form-group">
                      <input class="form-control" name="booking-email" type="email" placeholder="Your Email Address">
                    </div>
                    <!-- ROOM TYPE -->
                    <div class="form-group">
                      <select class="form-control" name="booking-roomtype" title="Select Room Type" data-header="Room Type" disabled="disabled">
                        <option value="Single" selected="selected">Single Room</option>
                        <option value="Double">Double Room</option>
                        <option value="Deluxe">Deluxe Room</option>
                      </select>
                    </div>
                    <!-- DATE -->
                    <div class="form-group">
                      <div class="form_date">
                        <input type="text" class="datepicker form-control" name="booking-checkin" placeholder="Slect Arrival & Departure Date" readonly="readonly">
                      </div>
                    </div>
                    <!-- GUESTS -->
                    <div class="form-group">
                      <div class="panel-dropdown">
                        <div class="form-control guestspicker">Guests
                          <span class="gueststotal"></span></div>
                        <div class="panel-dropdown-content">
                          <div class="guests-buttons">
                            <label>Adults
                              <a href="#" title="" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="18+ years" data-original-title="Adults">
                                <i class="fa fa-info-circle"></i>
                              </a>
                            </label>
                            <div class="guests-button">
                              <div class="minus"></div>
                              <input type="text" name="booking-adults" class="booking-guests" value="0">
                              <div class="plus"></div>
                            </div>
                          </div>
                          <div class="guests-buttons">
                            <label>Cildren
                              <a href="#" title="" data-toggle="popover" data-placement="top" data-trigger="hover" data-content="Under 18 years" data-original-title="Children">
                                <i class="fa fa-info-circle"></i>
                              </a>
                            </label>
                            <div class="guests-button">
                              <div class="minus"></div>
                              <input type="text" name="booking-children" class="booking-guests" value="0">
                              <div class="plus"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- BOOKING BUTTON -->
                    <button type="submit" class="btn btn-dark btn-fw mt20 mb20">BOOK A ROOM</button>
                  </form>
                </div>
              </div>
            </aside>
            <!-- WIDGET -->
            <aside class="widget widget-help">
              <h4 class="widget-title">NEED HELP?</h4>
              <div class="phone">
                <a href="tel:18475555555">
                  +1 888 123 4567
                </a>
              </div>
              <div class="email">
                <a href="mailto:contact@hotelhimara.com">contact@hotelhimara.com</a>
              </div>
            </aside>
            <!-- WIDGET -->
            <aside class="widget">
              <h4 class="widget-title">Latest Posts</h4>
              <div class="latest-posts">
                <!-- ITEM -->
                <div class="latest-post-item">
                  <div class="row">
                    <div class="col-5">
                      <figure class="gradient-overlay-hover link-icon sm">
                        <a href="blog-post.html">
                          <img src="images/blog/blog-post1.jpg" class="img-fluid" alt="Image">
                        </a>
                      </figure>
                    </div>
                    <div class="col-7">
                      <div class="post-details">
                        <h6 class="post-title">
                          <a href="blog-post.html">10 Tips for Holiday Travel</a>
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ITEM -->
                <div class="latest-post-item">
                  <div class="row">
                    <div class="col-5">
                      <figure class="gradient-overlay-hover link-icon sm">
                        <a href="blog-post.html">
                          <img src="images/blog/blog-post2.jpg" class="img-fluid" alt="Image">
                        </a>
                      </figure>
                    </div>
                    <div class="col-7">
                      <div class="post-details">
                        <h6 class="post-title">
                          <a href="blog-post.html">Are you ready to enjoy your holidays</a>
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ITEM -->
                <div class="latest-post-item">
                  <div class="row">
                    <div class="col-5">
                      <figure class="gradient-overlay-hover link-icon sm">
                        <a href="blog-post.html">
                          <img src="images/blog/blog-post3.jpg" class="img-fluid" alt="Image">
                        </a>
                      </figure>
                    </div>
                    <div class="col-7">
                      <div class="post-details">
                        <h6 class="post-title">
                          <a href="blog-post.html">Honeymoon in Hotel Himara</a>
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ITEM -->
                <div class="latest-post-item">
                  <div class="row">
                    <div class="col-5">
                      <figure class="gradient-overlay-hover link-icon sm">
                        <a href="blog-post.html">
                          <img src="images/blog/blog-post4.jpg" class="img-fluid" alt="Image">
                        </a>
                      </figure>
                    </div>
                    <div class="col-7">
                      <div class="post-details">
                        <h6 class="post-title">
                          <a href="blog-post.html">Travel Gift Ideas for Every Type of Traveler</a>
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- ITEM -->
                <div class="latest-post-item">
                  <div class="row">
                    <div class="col-5">
                      <figure class="gradient-overlay-hover link-icon sm">
                        <a href="blog-post.html">
                          <img src="images/blog/blog-post5.jpg" class="img-fluid" alt="Image">
                        </a>
                      </figure>
                    </div>
                    <div class="col-7">
                      <div class="post-details">
                        <h6 class="post-title">
                          <a href="blog-post.html">Breakfast with coffee and orange juic</a>
                        </h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </aside>
            <!-- WIDGET -->
            <aside class="widget noborder">
              <img src="images/banner.jpg" class="img-fluid" alt="Image">
            </aside>
          </div>
        </div>
      </div>
    </div>
</main>
@endsection
@section('js')

@endsection
