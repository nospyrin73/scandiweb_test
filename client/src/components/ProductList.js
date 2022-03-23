import { useState } from 'react';
import classNames from 'classnames';

import './ProductList.scss'

function ProductList({ products, ...props }) {
    return (
        <div className="product-list">
            {products.map(({ sku, name, price }) => {
                return (
                    <Product key={sku} sku={sku} name={name} price={price} shouldDelete={props.setShouldDelete} />
                );
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
export default ProductList;