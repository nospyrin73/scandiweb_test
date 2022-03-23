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

     function save() {
        const { sku, name, price, ...special } = values;

        let formData = new FormData();
        
        formData.append('sku', sku);
        formData.append('name', name);
        formData.append('price', price);
        formData.append('type', type);
        
        switch(type) {
            case 'DVD':
                formData.append('size', special.size);
                break;
            case 'Furniture':
                formData.append('height', special.height);
                formData.append('width', special.width);
                formData.append('length', special.length);
                break;
            case 'Book':
                formData.append('weight', special.weight);
                break;
            default:
        }
        
        fetch('/products/create', {
            method: 'POST',
            body: formData
        });
    }

    return (
        <main className="main">
            <Header label="Product Add">
                <button className="button success" onClick={save}>Save</button>
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