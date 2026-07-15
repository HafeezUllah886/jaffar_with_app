@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Create Account</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('account.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="title">Account Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mt-2">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="Business">Business</option>
                                        <option value="Customer">Customer</option>
                                        <option value="Vendor">Vendor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 mt-2" id="catBox">
                                <div class="form-group">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="Cash">Cash</option>
                                        <option value="Bank">Bank</option>
                                        <option value="Cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-6 mt-2 customer">
                                        <div class="form-group">
                                            <label for="cnic">Customer Category</label>
                                            <select name="c_type" id="c_type" class="form-control">
                                                <option value="Distributor">Distributor</option>
                                                <option value="Retailer">Retailer</option>
                                                <option value="Wholeseller">Wholeseller</option>
                                                <option value="Super Mart">Super Mart</option>
                                                <option value="Sub Dealer">Sub Dealer</option>
                                                <option value="Karyana Store">Karyana Store</option>
                                                <option value="Medical Store">Medical Store</option>
                                                <option value="Bakery Shop">Bakery Shop</option>
                                                <option value="Restaurant">Restaurant</option>
                                                <option value="Hotel">Hotel</option>
                                                <option value="Club">Club</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2 customer">
                                        <div class="form-group">
                                            <label for="cnic">CNIC #</label>
                                            <input type="text" name="cnic" id="cnic" value="{{ old('cnic') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2 customer">
                                        <div class="form-group">
                                            <label for="contact">Contact #</label>
                                            <input type="text" name="contact" id="contact" value="{{ old('contact') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2 customer">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" id="address" value="{{ old('address') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2 customer">
                                        <div class="form-group">
                                            <label for="ntn">NTN #</label>
                                            <input type="text" name="ntn" id="ntn" value="{{ old('ntn') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2 customer">
                                        <div class="form-group">
                                            <label for="strn">STRN #</label>
                                            <input type="text" name="strn" id="strn" value="{{ old('strn') }}"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2 customer">
                                        <div class="form-group">
                                            <label for="hidf">HIDF #</label>
                                            <input type="text" name="hidf" id="hidf"
                                                value="{{ old('hidf') }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-2 customer">
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <input type="text" name="latitude" id="latitude"
                                                    value="{{ old('latitude') }}" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2 customer">
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <div class="input-group">
                                                    <input type="text" name="longitude" id="longitude"
                                                        value="{{ old('longitude') }}" class="form-control" readonly>
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            data-toggle="modal" data-target="#mapModal"
                                                            data-bs-toggle="modal" data-bs-target="#mapModal">Get
                                                            Coordinates</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="initial">Initial Amount</label>
                                    <div class="input-group">
                                        <input type="number" step="any" id="initial" name="initial"
                                            value="0" min="0" class="form-control">
                                        <div class="input-group-append">
                                            <select class="form-control" name="initialType" id="inputGroupSelect04">
                                                <option value="0">Credit</option>
                                                <option value="1">Debit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-secondary w-100">Create</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Default Modals -->
    <!-- Map Modal -->
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Select Location</h5>
                    <button type="button" class="close btn-close" data-dismiss="modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="pac-input" class="controls form-control mb-2" type="text" placeholder="Search Box">
                    <div id="map" style="height: 400px; width: 100%; position: relative;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveLocationBtn" data-dismiss="modal"
                        data-bs-dismiss="modal">Save Location</button>
                </div>
            </div>
        </div>
    </div>

    <style>
        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
            margin-top: 10px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }
    </style>

@endsection


@section('page-js')
    <script>
        $(".customer").hide();
        $("#type").on("change", function() {
            var type = $("#type").find(":selected").val();

            if (type === "Business") {
                $("#catBox").show();
            } else {
                $("#catBox").hide();
            }

            if (type === "Customer") {
                $(".customer").show();
            } else {
                $(".customer").hide();
            }
        });

        let map;
        let marker;
        let selectedLat = 30.179139145257444; // Default: Karachi
        let selectedLng = 67.00025654670316;

        // Make initMap global so Google Maps API can call it
        window.initMap = function() {
            const defaultLocation = {
                lat: selectedLat,
                lng: selectedLng
            };

            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 12,
                center: defaultLocation,
                mapTypeControl: false,
            });

            marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true,
            });

            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                const bounds = new google.maps.LatLngBounds();

                places.forEach((place) => {
                    if (!place.geometry || !place.geometry.location) {
                        return;
                    }

                    marker.setPosition(place.geometry.location);
                    selectedLat = place.geometry.location.lat();
                    selectedLng = place.geometry.location.lng();

                    if (place.geometry.viewport) {
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
            });

            map.addListener("click", (e) => {
                marker.setPosition(e.latLng);
                selectedLat = e.latLng.lat();
                selectedLng = e.latLng.lng();
            });

            marker.addListener("dragend", (e) => {
                selectedLat = e.latLng.lat();
                selectedLng = e.latLng.lng();
            });
        };

        $('#mapModal').on('shown.bs.modal', function() {
            if (!map) {
                // If initMap is not yet ready, wait a bit or try to trigger it
                if (typeof google === 'object' && typeof google.maps === 'object') {
                    initMap();
                }
            } else {
                google.maps.event.trigger(map, 'resize');
                map.setCenter({
                    lat: selectedLat,
                    lng: selectedLng
                });
            }
        });

        $('#saveLocationBtn').click(function() {
            $('#latitude').val(selectedLat);
            $('#longitude').val(selectedLng);
        });
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places&callback=initMap"
        async defer></script>
@endsection
