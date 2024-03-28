@extends('layouts._main')
@section('content')

    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h2>
                            Purchase
                        </h2>
                        <a href="" class="btn btn-primary mb-4" data-bs-toggle="modal"
                            data-bs-target="#modalCreate">Create</a>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $key => $value)
                                    <tr>
                                        <td scope="row">{{ $key + 1 }}</th>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->role }}</td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <button class="btn btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#modalEdit-{{ $value->id }}">
                                                    <i class='bx bxs-pencil'></i>
                                                </button>
                                                <form action="{{ route('deleteUser', ['id' => $value->id]) }}"
                                                    class="px-4" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class='bx bx-trash'></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal Edit-->
                                    <div class="modal fade" id="modalEdit-{{ $value->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" style="margin-top: -20px;">
                                                    <form action="{{ route('updateUser', ['id' => $value->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            <div class="row g-3">
                                                                <div class="col">
                                                                    <input type="text" class="form-control"
                                                                        name="name" placeholder="Name User"
                                                                        aria-label="Name User" value="{{ $value->name }}">
                                                                </div>
                                                                <div class="col">
                                                                    <select name="role" id=""
                                                                        value={{ $value->role }} class="form-control">
                                                                        <option value="{{ $value->role }}" selected
                                                                            disabled>{{ $value->role }}</option>
                                                                        <option value="admin">Admin</option>
                                                                        <option value="employee">Employee</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3">
                                                                <div class="col">
                                                                    <input type="text" class="form-control"
                                                                        name="email" placeholder="email"
                                                                        aria-label="email" value="{{ $value->email }}">
                                                                </div>
                                                            </div>
                                                            <div class="row g-3">
                                                                <div class="col">
                                                                    <input type="password" class="form-control"
                                                                        name="password" placeholder="password"
                                                                        aria-label="password">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer"
                                                            style="margin-bottom: -30px; margin-top:20px;">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Modal Create-->
                    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="margin-top: -20px;">
                                    <form method="POST" action="">
                                        @csrf

                                        <hr>

                                        <label for="products">Products:</label>
                                        <div id="products-container">
                                            <div class="product-item">
                                                <div class="row">
                                                    <div class="row g-3">
                                                        <div class="col">
                                                            <select name="products[0][product_id]" id="product"
                                                                class="form-control">
                                                                <option value="" selected>Select product</option>
                                                                @foreach ($product as $p)
                                                                    <option value="{{ $p->id }}"
                                                                        data-price="{{ $p->price }}">
                                                                        {{ $p->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" name="products[0][price]"
                                                                class="form-control" id="price" placeholder="Price"
                                                                id="price" disabled>
                                                        </div>
                                                        <div class="col">
                                                            <input type="number" name="products[0][quantity]"
                                                                class="form-control" placeholder="Quantity"
                                                                id="quantity" required>
                                                        </div>

                                                        <div class="col">
                                                            <input type="text" name="products[0][totalPrice]"
                                                                id="totalPrice" class="form-control" 
                                                                placeholder="Total Price" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="margin-bottom: -30px; margin-top:20px;">
                                            <button type="button" class="btn btn-primary mt-2" id="add-product">Add
                                                Product</button>

                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('add-product').addEventListener('click', function() {
            const productsContainer = document.getElementById('products-container');
            const productCount = productsContainer.querySelectorAll('.product-item').length;
            const newProductItem = `
                <div class="product-item mt-2">
                    <div class="row">
                                                    <div class="row g-3">
                                                        <div class="col">
                                                            <select name="products[0][product_id]" id="product"
                                                                class="form-control">
                                                                <option value="" selected>Select product</option>
                                                                @foreach ($product as $p)
                                                                    <option value="{{ $p->id }}"
                                                                        data-price="{{ $p->price }}">
                                                                        {{ $p->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <input type="number" name="products[${productCount}][quantity]"
                                                                class="form-control" placeholder="Quantity" required>
                                                        </div>
                                                        <div class="col">
                                                            <input type="text" name="products[${productCount}][price]"
                                                                class="form-control" placeholder="Price" id="price" required>
                                                        </div>
                                                    </div>
                                                </div>
                </div>
            `;
            productsContainer.insertAdjacentHTML('beforeend', newProductItem);
        });
    </script>
    <script>
        // Mendengarkan perubahan pada select box produk
        document.getElementById('product').addEventListener('change', function() {
            // Mendapatkan nilai harga dari opsi yang dipilih
            var selectedProduct = this.options[this.selectedIndex];
            var price = selectedProduct.getAttribute('data-price');

            // Mengonversi harga menjadi format mata uang rupiah
            var formattedPrice = formatRupiah(price, 'Rp. ');

            // Mengisi nilai input harga dengan harga produk yang dipilih dalam format rupiah
            document.getElementById('price').value = formattedPrice;
        });

        function updateTotalPrice() {
            const quantity = parseFloat(quantityInput.value);
            const price = parseFloat(priceInput.value);

            if (!isNaN(quantity) && !isNaN(price)) {
                const totalPrice = quantity * price;
                totalPriceInput.value = totalPrice.toFixed(2); // Menggunakan 2 desimal untuk totalPrice
            } else {
                totalPriceInput.value = ''; // Kosongkan totalPrice jika input quantity atau price tidak valid
            }
        }

        function formatRupiah(angka) {
            var formatted = 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return formatted;
        }
        document.getElementById('quantity').addEventListener('input', updateTotalPrice);
        document.getElementById('price').addEventListener('input', updateTotalPrice);

        function updateTotalPrice() {
            const quantity = parseFloat(document.getElementById('quantity').value);
            const price = parseFloat(document.getElementById('price').value);
            const totalPriceInput = document.getElementById('totalPrice');

            if (!isNaN(quantity) && !isNaN(price)) {
                const totalPrice = quantity * price;
                totalPriceInput.value = totalPrice.toFixed(2); // Menggunakan 2 desimal untuk totalPrice
            } else {
                totalPriceInput.value = ''; // Kosongkan totalPrice jika input quantity atau price tidak valid
            }
        }
    </script>



@endsection
