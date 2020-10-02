@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('On Sale')])

@section('content')

@php
    if ($prod->prod_id== "ANML") {
        $product_information = $prod->animal;
    } elseif($prod->prod_id== "POULT") {
        $product_information = $prod->brood;
    }else {
        $product_information = $prod->storage->plantation;
    }
    
@endphp

<!--Section: Block Content-->
<section class="mb-5" >

    <div class="row" style="width: 70%; margin: auto;">
        <div class="col-md-6 mb-4 mb-md-0" style="margin-top: 100px">

            <div id="mdb-lightbox-ui">

            <div class="mdb-lightbox">

                    <div class="col-12 mb-0">
                        <figure class="view overlay rounded z-depth-1 main-img">
                            <a href=""  
                             >
                                    <img class="img-rounded"  src="{{ asset('material') }}/img/{{lcfirst($product_information->species)}}.jpg"class="img-fluid z-depth-1"><br>                                 
                            </a>
                        </figure>

                        <div>
                            <p><span class="mr-1"><strong> Ksh. {{$prod->price}} {{($prod->prod_id !== 'ANML'? ($prod->prod_id === 'PLT'? 'Per Sack': 'Per Bird'):'')}}</strong></span></p>
                            <p class="pt-1">Top Notch <span class="text-primary">{{ucfirst($product_information->species)}}</span> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni tenetur pariatur atque nesciunt 
                                minus nobis deserunt from <span class="text-success">{{ ucfirst($product_information->farmer->location)}} </span> Laboriosam, non impedit fugit atque consequuntur voluptates eius modi nulla ab dolorem!.</p>
                        </div>
                    </div>
                </div>

            </div>
            

        </div>
        <div class="col-md-6" style="margin-top: 100px">
          <form action="{{route('place_order',$prod)}}" method="post">
            @csrf
            <div class="table-responsive">
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                        <tr>
                            <th class="pl-0 w-25" scope="row">
                            <strong>
                                @if ($prod->prod_id === 'ANML')
                                <span style="color: rgb(15, 28, 8)">{{$product_information->name}}</span><span style="color: rgb(19, 197, 108)">&nbsp;
                                    (@if ($product_information->species=='cow')
                                      {{($product_information->gender == 'male')? 'Bull' : 'Cow' }}
                                    @elseif ($product_information->species=='sheep')
                                      {{($product_information->gender == 'male')? 'Ram' : 'Ewe' }}
                                    @elseif ($product_information->species=='goat')
                                        {{($product_information->gender == 'male')? 'Billy-Goat' : 'nanny-goat' }}
                                    @else
                                      {{($product_information->gender == 'male')? 'Male' : 'Female' }}
                                    @endif)                        
                                    </span>
                                @elseif($prod->prod_id === 'POULT')
                                <span style="color: rgb(15, 28, 8)">{{ ucfirst($product_information->species)}}</span><span style="color: rgb(19, 197, 108)">&nbsp;
                                    @if ($product_information->species=='chicken' || $product_information->species=='turkey')
                                      {{($product_information->gender == 'male')? 'Broiler' : 'Layer' }}
                                    @endif                       
                                    </span>
                                @else
                                    {{$product_information->species}}                                    
                                @endif
                            </strong>
                            </th>
                        </tr>
                        @if ($prod->prod_id === 'PLT')
                            <tr>
                                <th class="pl-0 w-25" scope="row"><strong>Strain Number</strong></th>
                            <td>{{ucfirst($product_information->plant_fact_sheet->type)}}</td>
                        </tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
            @if ($prod->prod_id === 'PLT' || $prod->prod_id === 'POULT' )
            <div class="table-responsive mb-2">
                <table class="table table-sm table-borderless">
                    <tbody>
                        <tr>
                            <td class="pl-0 pb-0 w-25">Quantity</td>
                        </tr>
                        <tr>
                            <td class="pl-0">
                                <div class="def-number-input number-input safari_only mb-0">

                                <input class="quantity" min="1" name="quantity" max="{{$prod->amount}}" value="1" type="number">

                                </div>
                            <small >{{$prod->amount.' '.($prod->prod_id=== 'PLT'?'Sacks':'Birds').' are available'}}</small>
                            </td>

                        </tr>

                        
                    </tbody>
                </table>
            </div>  
            @endif
            <tr>
              @if (auth()->user() !== null)
                  @if (auth()->user()->location === $product_information->farmer->location)
                      <th class="pl-0 w-25" scope="row"><small>Free Delivery Available</small></th>
                  @else
              <th class="pl-0 w-25" scope="row"><small>Free Delivery not Available in <span class="text-primary" >{{ucfirst(auth()->user()->location)}}</span></small> <br>
                          <input type = "radio"
                          name = "choice"
                          id = "pick"
                          value = "pick" required />
                   <label for = "pick">Pick At your local Station </label> &nbsp;
                 
                   <input type = "radio"
                          name = "choice"
                          id = "delivery"
                          value = "delivery" required />
                   <label for = "delivery">Home Delivery</label>
                      </th>
                  @endif
              @else
                  <th class="pl-0 w-25" scope="row"><small>Free Delivery in</small></th>
                  {{-- here.... --}}

                  <td>{{ucfirst($product_information->farmer->location)}}</td>
              @endif

          </tr>
            @if (auth()->user() === null)
                <button type="button" class="btn btn-primary btn-md mr-1 mb-2"  data-toggle="modal" data-target="#register" >Proced to Checkout</button>
            @else
                {{-- <button type="button" class="btn btn-primary btn-md mr-1 mb-2"  data-toggle="modal" data-target="#pay" ></i> Proced to Checkout</button> --}}
                <button type="submitt" value='submitt' class="btn btn-primary btn-md mr-1 mb-2"  ></i> Proced to Checkout</button>

            @endif
            <button type="button" class="btn btn-light btn-success"><i class="fa fa-shopping-basket pr-2"></i>Add to Basket</button>
          </form>
        </div>
      
    </div>

    <div id="register" class="modal fade " role="dialog" style="margin-top: 10%; ">
        <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" style="color: black"> Register </span> </h4>
              <strong  class="form-text text-muted">You must have an <span class="text-warning">Acount</span> To proceed ..</strong>
      
            </div>
            <div class="modal-body">
            <form action="" method="POST">
              @csrf
                <div class="first-column" style='width:45%; float: left;margin-right:1%'>
                  <div class="form-group">
                    <label for="type">Full Names</label>
                    <input type="text" class="form-control" name='name'id="name" aria-describedby="name" placeholder="Enter Your Full names" required>
                    <small id="type" class="form-text text-muted">As they appear on the id.</small>
                  </div>
                                         

                  <div class="form-group">
                    <label for="strain">Phone number</label>
                    <input type="text" name ='phone_number'class="form-control" id="phone_number" aria-describedby="phonenumber" placeholder="07XX-XXX-XXX" required>
                    <small id="phonenumber" class="form-text text-muted">Enter Phone number</small>
                  </div>            
                  <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name ='location'class="form-control" id="location" aria-describedby="loc" placeholder="eg. Nakuru.." required>
                    <small id="loc" class="form-text text-muted">Enter Location</small>
                  </div>
                  <label for="social">Or Register with </label> <br>
                  <button type="button" class="btn btn-facebook btn-icon btn-sm" >
                    <span class="btn-inner--icon btn-sm"><i class="fa fa-facebook"></i></span>
                </button>
                <button type="button" class="btn btn-instagram btn-icon btn-sm"style="background-color:rgb(242, 70, 99)">
                    <span class="btn-inner--icon btn-sm"><i class="fa fa-instagram"></i></span>
                </button>                </div>
               

              <div class="second-column" style='width:45%; float: right;margin-right:1%'>
                <div class="form-group">
                  <label for="size">Email</label>
                  <input type="email" name ='email'class="form-control" id="email" aria-describedby="mail" placeholder="abc@xyz.com" required>
                  <small id="mail" class="form-text text-muted">Enter Email</small>
                </div>
                
      
                <div class="form-group">
                  <label for="exp">Password..</label>
                  <input type="password" class="form-control" name='password' id="password" aria-describedby="password" placeholder="password"  required>
                  <small id="expirience" class="form-text text-muted">Password</small>
                </div>
                
                {{-- file uploader --}}
                <div class="form-group">
                  <label for="password">Confirm Password..</label>
                  <input type="password" class="form-control" name='conf_password' id="conf_password" aria-describedby="conf_password" placeholder="password" required>
                  <small id="password" class="form-text text-muted"> Confirm Password</small>
                </div>                    
                
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="agr" name="agr"  required>
                    <label class="custom-control-label" for="agr"> Agree to <a href="#" class="text-primary">terms and conditions</a> </label>
                  </div>                   
                </div> 
      
      
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info" value="Submit">Submit</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
            <input type="hidden" id="reg_type" name="reg_type" value="farmer">
          </form>
          </div>
        </div>
    </div>

    <div id="pay" class="modal fade" role="dialog">
        <div class="modal-dialog">
      
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Pay  T</h4>
            </div>
            <div class="modal-body">
            <form action="" method="post">
              @csrf
                
                <small> Thou JIM shall add the shopping basket details here</small>
                                         
              
              
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-info" value="Submit">Submit</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
          </form>
          </div>
      
        </div>
    </div>
</section>
<!--Section: Block Content-->
@endsection

