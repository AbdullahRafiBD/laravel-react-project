@php
    use App\Models\Product;
@endphp
<div class="row product-container grid-style">
                        @foreach ($vendorProducts as $product)
                        @php
                            $product_image_path = 'front/images/product_images/small/'.$product['product_image'];
                        @endphp
                        <div class="product-item col-lg-4 col-md-6 col-sm-6">
                            <div class="item">
                                <div class="image-container">
                                    <a class="item-img-wrapper-link" href="{{url('product/'.$product['id'])}}">
                                        @if (!empty($product['product_image']) && file_exists($product_image_path))
                                        <img class="img-fluid" src="{{asset($product_image_path)}}" alt="Product">
                                        @else
                                        <img class="img-fluid" src="{{asset('front/images/product_images/small/no-image.png')}}" alt="Product">
                                        @endif
                                    </a>
                                    <div class="item-action-behaviors">
                                        <a class="item-quick-look" data-toggle="modal" href="#quick-view">Quick Look</a>
                                        <a class="item-mail" href="javascript:void(0)">Mail</a>
                                        <a class="item-addwishlist" href="javascript:void(0)">Add to Wishlist</a>
                                        <a class="item-addCart" href="javascript:void(0)">Add to Cart</a>
                                    </div>
                                </div>
                                <div class="item-content">
                                    <div class="what-product-is">
                                        <ul class="bread-crumb">
                                            <li class="has-separator">
                                                <a href="{{url('product/'.$product['product_url'])}}">{{$product['product_code']}}</a>
                                            </li>
                                            <li class="has-separator">
                                                <a href="{{url('product/'.$product['product_url'])}}">{{$product['brand']['name']}}</a>
                                            </li>
                                            <li class="has-separator">
                                                <a href="listing.html">Tops</a>
                                            </li>
                                            <li>
                                                <a href="shop-v3-sub-sub-category.html">Hoodies</a>
                                            </li>
                                        </ul>
                                        <h6 class="item-title">
                                            <a href="{{url('product/'.$product['product_url'])}}">{{$product['product_name']}}</a>
                                        </h6>
                                        <div class="item-description">
                                            <p>
                                                {{$product['product_long_description']}}
                                            </p>
                                        </div>
                                        <div class="item-stars">
                                            <div class='star' title="4.5 out of 5 - based on 23 Reviews">
                                                <span style='width:67px'></span>
                                            </div>
                                            <span>(23)</span>
                                        </div>
                                    </div>

                                    @php
                                        $getDiscountPrice = Product::getDiscountPrice($product['id']);
                                    @endphp
                                    @if ($getDiscountPrice>0)
                                        <div class="price-template">
                                        <div class="item-new-price">
                                            ${{$getDiscountPrice}}
                                        </div>
                                        <div class="item-old-price">
                                            ${{$product['product_price']}}
                                        </div>
                                    </div>
                                    @else
                                        <div class="price-template">
                                        <div class="item-new-price">
                                            ${{$product['product_price']}}
                                        </div>

                                    </div>
                                    @endif

                                </div>
                                @php
                                    $isProductNew = Product::isProductNew($product['id']);
                                @endphp
                                @if ($isProductNew=='Yes')
                                <div class="tag new">
                                    <span>NEW</span>
                                </div>
                                @endif

                            </div>
                        </div>
                        @endforeach

                    </div>
