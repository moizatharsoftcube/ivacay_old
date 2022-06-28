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
                    <form role="form" action="{{route('package_stripe_post')}}" method="post" class="require-validation"
                          data-cc-on-file="false" data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                          id="payment-form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12  align-content-center col-xs-12 sign_btn">
                                <button id="connectBtn" class="btn  btn-lg btn-block ">Connect Wallet</button>
                            </div>
                        </div>

                        <input type="text" name="package_id" hidden value="{{$package_id}}">
                        <div class='form-row row'>
                            <div class='col-md-12 col-sm-12 col-xs-12 form-group required'>
                                <div class="my_re">
                                    <label class='control-label'>Enter Address</label>
                                    <input class='form-control' type="text" placeholder="Enter Address" id="address">
                                </div>
                            </div>
                        </div>
                        <div class='form-row row'>
                            <div class='col-md-12 col-sm-12 col-xs-12 form-group '>
                                <div class="my_re">
                                    <label class='control-label'>Enter Ethers</label>
                                    <input class='form-control' type="number" placeholder="Enter ethers" id="ethers">

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 sign_btn">

                                <button class="btn  btn-lg btn-block" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    @push('js')
        <script src="https://cdn.ethers.io/lib/ethers-5.2.umd.min.js"
                type="application/javascript">


        const connectBtn = document.querySelector('#connectBtn');

        connectBtn.addEventListener('click', async() => {
        // Will Start the metamask extension
        if (typeof window.ethereum !== 'undefined') {
        console.log('MetaMask is installed!');
        } else {
        console.log("No crypto wallet found. Please install it.")
        }

        const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
        const account1 = accounts[0]
        console.log(account1)

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
        console.log({ ether, addr });
        console.log("transaction", transaction);
        } catch (err) {
        console.log(err.message)
        }
        }


        const form = document.querySelector("form");

        form.addEventListener("submit", e => {

        const addressInput = document.querySelector("#address");
        const ethersInput = document.querySelector("#ethers");
        console.log(1, addressInput.value)
        console.log(2, ethersInput.value)
        e.preventDefault();
        startPayment({ether: "0.0001", addr: "0xd897b34b6F7B3E6cd6984eA39adDC99582F4f67f"})
        // startPayment({ether: ethersInput.value, addr: addressInput.value})
        })
        </script>

    @endpush
@endsection






