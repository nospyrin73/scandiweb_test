import { useState } from 'react';
import classNames from 'classnames';

import './ProductList.scss'

function ProductList() {
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

    return (
        <div className="product-list">
            {products.map(({ sku, name, price }) => {
                return <Product key={sku} sku={sku} name={name} price={price} shouldDelete={setShouldDelete} />
            })}
        </div>
    );
}

function Product({ sku, name, price, shouldDelete }) {
    const [isChecked, setIsChecked] = useState(false);

    return (
        <div className={classNames('product-card', 'shadow', {'marked': isChecked})} 
        onClick={event => shouldDelete(sku, setIsChecked)}>
            <label className="checkbox-label">
                <input type="checkbox" name="" className="delete-checkbox" checked={isChecked} onChange={event => shouldDelete(sku, setIsChecked)}/>
                <span></span>
            </label>
            
            <div>{sku}</div>
            <div>{name}</div>
            <div>{price}</div>
            <div>Size: 700 MB</div>
        </div>
    );
}


/*
<div>JVC200123</div>
<div>Acme DISC</div>
<div>1.00 $</div>
<div>Size: 700 MB</div>
*/
export default ProductList;