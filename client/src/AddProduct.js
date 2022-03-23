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
        validate();

        const { sku, name, price, ...special } = values;

        let formData = new FormData();
        
        formData.append('sku', sku);
        formData.append('name', name);
        formData.append('price', price);
        formData.append('type', type);
        
        switch (type) {
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

    function validate() {
        const { sku, name, price, ...special } = values;
        
        const expectNonEmpty = [sku, name, price];
        const expectNonNaN = [price];

        switch (type) {
            case 'DVD':
                expectNonEmpty.push(special.size);
                expectNonNaN.push(special.size);
                break;
            case 'Furniture':
                expectNonEmpty.push(special.height, special.weight, special.length);
                expectNonNaN.push(special.height, special.weight, special.length);
                break;
            case 'Book':
                expectNonEmpty.push(special.weight);
                expectNonNaN.push(special.weight);
                break;
            default:
        }

        if (expectNonEmpty.includes("")) {
            console.log('expectNonEmpty found an empty: ');
            console.log(expectNonEmpty); 
        }

        if (expectNonNaN.some( val => isNaN(val) )) {
            console.log('expectNonNaN found a nan: ');
            console.log(expectNonNaN);
        }

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