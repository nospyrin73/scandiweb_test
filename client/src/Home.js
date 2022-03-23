import { useState } from 'react';
import { Link } from 'react-router-dom';

import Header from './components/Header';
import ProductList from './components/ProductList';
import Footer from './components/Footer';

function Home() {
    const [products, setProducts] = useState([
        {sku: 1, name: 'foo', price: '23$'},
        {sku: 2, name: 'bar', price: '25$'},
        {sku: 3, name: 'baz', price: '32$'},
        {sku: 4, name: 'mal', price: '94$'},
        {sku: 5, name: 'par', price: '72$'},
    ]);
    const [toBeDeleted, setToBeDeleted] = useState([]);

    function setShouldDelete(sku, setIsChecked) {
        let i = toBeDeleted.indexOf(sku);

        if (i === -1) {
            toBeDeleted.push(sku);
            setToBeDeleted(toBeDeleted);
            
            setIsChecked(true);
        } else {
            toBeDeleted.splice(i, 1);
            setToBeDeleted(toBeDeleted);

            setIsChecked(false);
        }
    }

    function massDelete() {
        const filtered = products.filter(product => {
            // if it shouldn't be deleted, add to new products array 'filtered'
            return !toBeDeleted.includes(product.sku);
        });

        setProducts(filtered);
    }

    return (
        <main className="main">
            <Header label="Product List">
                <Link to="/add-product" className="button primary">Add</Link>
                <button className="button danger" onClick={massDelete}>Mass Delete</button>
            </Header>

            <article className="content">
                <ProductList products={products} setShouldDelete={setShouldDelete}/>
            </article>

            <Footer />
        </main>
    );
}

export default Home;