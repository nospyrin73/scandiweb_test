import { useState } from 'react';
import { Link } from 'react-router-dom';

import Header from './components/Header';
import ProductForm from './components/ProductForm';
import Footer from './components/Footer';

import './AddProduct.scss'

const defaultValues = {
    sku: '', name: '', price: '',
    size: '',
    height: '', width: '', length: '',
    weight: ''
};

function AddProduct() {
    const [values, setValues] = useState(defaultValues);
    const [type, setType] = useState('default');

    function handleChange(event) {
        const { name, value } = event.target;

        setValues({
            ...values,
            [name]: value
        });
    }

    function switchType(event) {
        setType(event.target.value);
        setValues(defaultValues);
    }

   

    return (
        <main className="main">
            <Header label="Product Add">
                <button className="button success">Save</button>
                <Link to="/" className="button secondary">Cancel</Link>
            </Header>

            <article className="content">
                <ProductForm values={values} type={type} 
                handleChange={handleChange} switchType={switchType}/>
            </article>

            <Footer />
        </main>
    );
}

export default AddProduct;