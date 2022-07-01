@extends('layouts.main')
@section('content')
    @push('css')
        <style>

            .my_crpto h1 {
                font-family: "Poppins", Sans-Serif;
                font-size: 50px;
                line-height: 65px;
                color: #fff;
                font-weight: 600;
                margin: 0 0 0px;
                text-transform: uppercase;
                text-align: center;
                width: 80%;
                margin: 0 auto;
            }

            section.faq_sec {
                position: relative;
                z-index: 9;
            }

            .my_re label.control-label {
                color: #fff;
                font-size: 15px;
                line-height: 40px;
            }

            .my_re input {
                border: 1px solid #fff;
                background: transparent;
            }

            .light-mode .my_re input {
                border: 1px solid #000;
                color: #000;
            }

            .light-mode .my_re label.control-label {
                color: #000;
            }
        </style>

    @endpush

    <!-- banner start -->
    <section class="main_slider">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="banner_text my_crpto text-center">
                        <h1>Payment Information (Ethereum)</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- banner end -->

    <section class="faq_sec">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-8 centerCol">
{{--                    <form role="form" action="{{route('package_stripe_post')}}" method="post" class="require-validation"--}}
{{--                          data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"--}}
{{--                          id="payment-form">--}}
{{--                        @csrf--}}
                        <div class="row">
                            <div class="col-lg-12  align-content-center col-xs-12 sign_btn">
                                <button id="connectBtn" class="btn  btn-lg btn-block ">Connect Wallet</button>
                                <button id="payEthBtn" class="btn  btn-lg btn-block ">Pay Now</button>
                            </div>
                        </div>

{{--                        <input type="text" name="package_id" hidden value="{{$package_id}}">--}}
{{--                        <div class='form-row row'>--}}
{{--                            <div class='col-md-12 col-sm-12 col-xs-12 form-group required'>--}}
{{--                                <div class="my_re">--}}
{{--                                    <label class='control-label'>Enter Address</label>--}}
{{--                                    <input class='form-control' type="text" placeholder="Enter Address" id="address">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class='form-row row'>--}}
{{--                            <div class='col-md-12 col-sm-12 col-xs-12 form-group '>--}}
{{--                                <div class="my_re">--}}
{{--                                    <label class='control-label'>Enter Ethers</label>--}}
{{--                                    <input class='form-control' type="number" placeholder="Enter ethers" id="ethers">--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-xs-12 sign_btn">--}}

{{--                                <button class="btn  btn-lg btn-block" type="submit">Submit</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                </div>
            </div>

        </div>
    </section>
    @push('js')
        <script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js"
                type="application/javascript"></script>
        <script>

            $(document).ready(function() {
                let eth_url = 'https://min-api.cryptocompare.com/data/price?fsym=ETH&tsyms=ETH,USD';
                let eth_data ="" ;
                let eth_res = AjaxRequest_get(eth_url,eth_data);

                var pkg_price = 0;
                let url = '{{route('eth_conversion',$package_id)}}';
                let data = {'eth_res_usd':eth_res.USD,'_token':'{{csrf_token()}}'};
                let res = AjaxRequest(url,data);
                if(res.status == 1)
                {
                    // var pkg_price =  res.pkg_eth; //For Live
                    var pkg_price =  0.00001; //For Testing
                }else{
                    var pkg_price = 0;
                    toastr["error"]("Ethereum conversion error");
                }

            const connectBtn = document.querySelector('#connectBtn');

            connectBtn.addEventListener('click', async() => {
                // Will Start the metamask extension
                if (typeof window.ethereum !== 'undefined') {
                    toastr["success"]("MetaMask is installed!");

                } else {
                    toastr["error"]("No crypto wallet found. Please install it.");
                }

                const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
                const account1 = accounts[0]
                // console.log(account1)

            });

            const startPayment = async ({ ether, addr }) => {
                try {
                    if (!window.ethereum) throw new Error("No crypto wallet found. Please install it.");

                    await window.ethereum.send("eth_requestAccounts");
                    const provider = new ethers.providers.Web3Provider(window.ethereum);
                    const signer = provider.getSigner();
                    ethers.utils.getAddress(addr);

                    const transaction = await signer.sendTransaction({
                        to: addr,
                        value: ethers.utils.parseEther(ether)
                    });
                    // console.log({ ether, addr });
                    // console.log("transaction", transaction);
                    const { hash, from } = transaction;
                    // console.log(hash);
                    // return false;
                    let val_meta_url = 'https://blockexplorer.rinkeby.boba.network/api?module=transaction&action=gettxreceiptstatus&txhash='+hash;
                    let val_meta_data ="" ;
                    let val_meta_res = AjaxRequest_get(val_meta_url,val_meta_data);


                    if(val_meta_res.status==1)
                    {
                        var url = '{{route('Vacationer_meta_form',$package_id)}}';
                        var data = {'hash':hash,'from':from,'_token':'{{csrf_token()}}'};
                        var res = AjaxRequest(url,data);
                        toastr["success"](res.message);
                    }
                    else
                    {
                            toastr["error"](val_meta_res.message);
                    }

                } catch (err) {
                    toastr["error"](err.message);
                }
            }


            // const form = document.querySelector("form");
            const payEthBtn = document.querySelector("#payEthBtn");

            payEthBtn.addEventListener("click", () => {

                // const addressInput = document.querySelector("#address");
                // const ethersInput = document.querySelector("#ethers");
                // console.log(1, addressInput.value)
                // console.log(2, ethersInput.value)
                // e.preventDefault();
                if(pkg_price != 0){
                    // console.log(pkg_price.toString());
                startPayment({ether: pkg_price.toString(), addr: "0x85daC253A7F3E43bAa693127Ace50688416aD792"})
                // ether for payment
                // addr for ivacay owner account
                //     ''+pkg_price+''
                // startPayment({ether: ethersInput.value, addr: addressInput.value})

                }else{
                    toastr["error"]("Price Not Found");
                }
            })
            });
        </script>

    @endpush
@endsection






