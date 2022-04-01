import { useState, useEffect } from 'react';
import { Link } from 'react-router-dom';

import Header from './components/Header';
import ProductList from './components/ProductList';
import Footer from './components/Footer';

async function fetchProducts() {
    let response = await fetch('/products');

    if (!response.ok) {
        console.error(await response.text());
        
        return [];
    }

    let isJson = response.headers.get('content-type')?.includes('application/json');

    if (isJson) {
        return await response.json();
    } else {
        console.error(await response.text())

        return [];
    }
}

function Home() {
    const [products, setProducts] = useState([]);
    const [toBeDeleted, setToBeDeleted] = useState([]);
    const [refs, setRefs] = useState([]);

    useEffect(() => {
        (async () => {
            setProducts(await fetchProducts());
        })();
    }, []);

    function setShouldDelete(sku, setIsChecked, checkbox) {
        let i = toBeDeleted.indexOf(sku);

        if (i === -1) {
            toBeDeleted.push(sku);
            setToBeDeleted(toBeDeleted);
            
            setIsChecked(true);
            checkbox.checked = true;
        } else {
            toBeDeleted.splice(i, 1);
            setToBeDeleted(toBeDeleted);

            setIsChecked(false);
            checkbox.checked = false;
        }
    }

    async function massDelete() {
        const filtered = products.filter(product => {
            // if it shouldn't be deleted, add to new products array 'filtered'
            return toBeDeleted.includes(product.sku) || refs[product.sku].current.checked;
        });

        const result = await fetch('/products', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({filtered})
        });

        const deleted = await result.json();

        const updatedProducts = products.filter(product => {
            return !deleted.includes(product.sku);
        });

        setProducts(updatedProducts);
    }

    function addRef(sku, ref) {
        refs[sku] = ref;

        setRefs(refs);
    }

    return (
        <main className="main">
            <Header label="Product List">
                <Link to="/add-product" className="button primary">ADD</Link>
                <button id="delete-product-btn" className="button danger" onClick={massDelete}>MASS DELETE</button>
            </Header>

            <article className="content">
                <ProductList products={products} setShouldDelete={setShouldDelete} addRef={addRef}/>
            </article>

            <Footer />
        </main>
    );
}

export default Home;