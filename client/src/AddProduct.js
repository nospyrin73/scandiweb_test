import Header from './components/Header';
import ProductForm from './components/ProductForm';
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

export default AddProduct;