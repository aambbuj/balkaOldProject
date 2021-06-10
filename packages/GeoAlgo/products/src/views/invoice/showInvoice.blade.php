<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}">
</head>

<body>
    <div class="container my-5" id="savePdf">
        <div class="row">
            <div class="col-md-12">
                <div class="ace__invoice_details">
                    <h2>Invoice</h2>
                    <p>Invoice No: <span>{{$invoiceDetails->order_number}}</span></p>
                    <p>Invoice Date: <span>{{$invoiceDetails->order_date}}</span></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ace__details">
                    <h2>ACE Wine</h2>
                    <p>190 North Bend River Road <br> Zip Code: 41635</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="ace__bill_to">
                    <h2>Bill To</h2>
                    <p>{{$bar->company_name}} <br>{{$bar->address}} <br> Zip Code: {{$bar->pincode}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ace__ship_to">
                    <h2>Ship To</h2>
                    <p>{{$bar->company_name}} <br>{{$bar->address}} <br> Zip Code: {{$bar->pincode}}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col invoicetable-style table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                <p>Date Of Supply: <span>{{$invoiceDetails->order_date}}</span></p>
                <table class="table invoive_table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product SKU</th>
                            <th scope="col" class="pn">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="invoice-body">
                        <?php $subtotal=0; ?>
                        @foreach($invoiceDetails->details as $detail)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{$detail->sku}}</td>
                            <td class="pn">{{$detail->product_name}}</td>
                            <td>{{$detail->pivot->qty}}</td>
                            <td>$ {{$detail->unit_price}}</td>
                            <td>$ {{$detail->discount}}</td>
                            <td>$ {{$detail->pivot->total_amount}}</td>
                        </tr>
                        <?php $subtotal=$subtotal+$detail->pivot->total_amount; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="total_invoice_amount table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Subtotal</th>
                                <th scope="col">$ {{$subtotal}}</th>
                            </tr>
                        </thead>
                        <tbody class="tax">
                            <tr>
                                <?php $tax=0; 
                                   $tax=$tax+(($subtotal*0)/100)
                                ?>
                                <td>Taxable Amount</td>
                                <td>{{$tax}}</td>
                            </tr>
                        </tbody>
                        <thead class="thead-light">
                            <tr>
                                <?php $grandtotal=0;
                                   $grandtotal=$grandtotal+($subtotal+$tax);
                                 ?>
                                <th scope="col">Total</th>
                                <th scope="col">$ {{$grandtotal}}</th>
                            </tr>
                        </thead>
                    </table>
                    <p class="in-text">Total In Words: Two hundred thirty Only</p>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
                <p class="bank-name-details">Bank Details</p>
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Account Holder Name</th>
                            <th scope="col">Account No</th>
                            <th scope="col">IFSC Code</th>
                            <th scope="col">Name</th>
                        </tr>
                    </thead>
                    <tbody class="bank-info">
                        <tr>
                            <td>ACE Wine</td>
                            <td>1234567891011</td>
                            <td>XB7891011</td>
                            <td>XBank</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row ">
            <div class="col">
                <div class="ace__sig ">
                    <h4>For, ACE WINE</h4>
                    <p class="signature">Joan J. Edwards</p>
                    <p class="sig-label">Authorized Signature </p>
                </div>
            </div>
        </div>
    </div>
    <button class="print_button" onclick="window.print()">Print Invoice </button>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>