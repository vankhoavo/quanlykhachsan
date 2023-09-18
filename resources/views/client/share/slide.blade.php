<div class="slider">
    <div class="fullscreen-container">
        <div id="rev-slider-3" class="rev_slider" style="display:none; background: #444;" data-version="5.4.5">
            <ul>
                @foreach ($slide as $key => $value)
                    @if ($key == 0)
                        <li data-transition="slidingoverlayright">
                        @else
                        <li data-transition="slidingoverlayright" data-slotamount="7" data-easein="default"
                            data-easeout="default" data-masterspeed="1000">
                    @endif
                    <!-- MAIN IMAGE -->
                    <img src="{{ $value }}" alt="Image" title="Image" data-bgposition="center center"
                        data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg"
                        data-no-retina="">
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <!-- ========== BOOKING FORM ========== -->
    <div class="horizontal-booking-form booking-form-over-slider">
        <div class="container">
            <div class="inner box-shadow-007">
                <!-- ========== BOOKING NOTIFICATION ========== -->
                <div id="booking-notification" class="notification"></div>
                <form action="/booking-process" method="post">
                    @csrf
                    <!-- NAME -->
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Name
                                    <a href="/client/#" title="Your Name" data-toggle="popover" data-placement="top"
                                        data-trigger="hover" data-content="Please type your first name and last name">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="form-control" name="booking-name" type="text" data-trigger="hover"
                                    placeholder="Write Your Name">
                            </div>
                        </div>
                        <!-- EMAIL -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Email
                                    <a href="/client/#" title="Your Email" data-toggle="popover" data-placement="top"
                                        data-trigger="hover" data-content="Please type your email adress">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </label>
                                <input class="form-control" name="booking-email" type="email"
                                    placeholder="Write your Email">
                            </div>
                        </div>
                        <!-- ROOM TYPE -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Room Type
                                    <a href="/client/#" title="Room Type" data-toggle="popover" data-placement="top"
                                        data-trigger="hover" data-content="Please select room type">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </label>
                                <select class="form-control" name="booking-roomtype" title="Select Room Type"
                                    data-header="Room Type">
                                    @foreach ($loaiPhong as $value)
                                    <option value="{{ $value->id }}">{{ $value->ma_phong }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- DATE -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Check-In/Out
                                    <a href="/client/#" title="Check-In / Check-Out" data-toggle="popover"
                                        data-placement="top" data-trigger="hover"
                                        data-content="Please select check-in and check-out date <br>*Check In from 11:00am">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </label>
                                <input type="text" class="datepicker form-control" name="booking-date"
                                    placeholder="Arrival & Departure" readonly="readonly">
                            </div>
                        </div>
                        <!-- GUESTS -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Guests
                                    <a href="/client/#" title="Guests" data-toggle="popover" data-placement="top"
                                        data-trigger="hover" data-content="Please Select Adults / Children">
                                        <i class="fa fa-info-circle"></i>
                                    </a>
                                </label>
                                <div class="panel-dropdown">
                                    <div class="form-control guestspicker">Guests
                                        <span class="gueststotal"></span>
                                    </div>
                                    <div class="panel-dropdown-content">
                                        <div class="guests-buttons">
                                            <label>Adults
                                                <a href="/client/#" title="" data-toggle="popover"
                                                    data-placement="top" data-trigger="hover"
                                                    data-content="18+ years" data-original-title="Adults">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <div class="guests-button">
                                                <div class="minus"></div>
                                                <input type="text" name="booking-adults" class="booking-guests"
                                                    value="0">
                                                <div class="plus"></div>
                                            </div>
                                        </div>
                                        <div class="guests-buttons">
                                            <label>Cildren
                                                <a href="/client/#" title="" data-toggle="popover"
                                                    data-placement="top" data-trigger="hover"
                                                    data-content="Under 18 years" data-original-title="Children">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            </label>
                                            <div class="guests-button">
                                                <div class="minus"></div>
                                                <input type="text" name="booking-children" class="booking-guests"
                                                    value="0">
                                                <div class="plus"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BOOKING BUTTON -->
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-book">BOOK A ROOM</button>
                            <div class="advanced-form-link">
                                <a href="/client/booking-form.html">
                                    Advanced Booking Form
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
