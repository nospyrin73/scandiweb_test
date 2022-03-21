import { useState } from 'react';

import Header from './components/Header';
import Footer from './components/Footer';

import './AddProduct.scss'

function AddProduct() {
    return (
        <main className="main">
            <Header label="Product Add">
                <button className="button success">Save</button>
                <button className="button secondary">Cancel</button>
            </Header>

            <article className="content"><ProductForm /></article>

            <Footer />
        </main>
    );
}

function ProductForm() {
    const [type, setType] = useState('');

    const types = {
        DVD: (
            <div>
                <label>
                    <span>Size (MB)</span>
                    <input type="text" name="size" id="size"/>
                </label>
                <p>Please provide size in MB</p>
            </div>
        ),
        Furniture: (
            <div>
                <label>
                    <span>Height (CM)</span>
                    <input type="text" name="height" id="height"/>
                </label>
                <label>
                    <span>Width (CM)</span>
                    <input type="text" name="width" id="width"/>
                </label>
                <label>
                    <span>Length (CM)</span>
                    <input type="text" name="length" id="length"/>
                </label>
                <p>Please provide dimensions HxWxL format</p>
            </div>
        ),
        Book: (
            <div>
                <label>
                    <span>Weight (KG)</span>
                    <input type="text" name="weight" id="weight"/>
                </label>
                <p>Please provide weight in Kg unit</p>
            </div>
        )
    };

    return (
        <form id="product_form">
            <section>
                <label>
                    <span>SKU</span>
                    <input type="text" name="" id="sku"/>
                </label>

                <label>
                    <span>Name</span>
                    <input type="text" name="name" id="name"/>
                </label>

                <label>
                    <span>Price</span>
                    <input type="text" name="price" id="price"/>
                </label>

                <label>
                    <span>Type Switcher</span>
                    <select>
                        <option disabled selected value> -- select an option -- </option>
                        <option id="DVD">DVD</option>
                        <option id="Furniture">Furniture</option>
                        <option id="Book">Book</option>
                    </select>
                </label>
            </section>
            <section>
                {types['DVD']}
            </section>
        </form>
    );
}

export default AddProduct;