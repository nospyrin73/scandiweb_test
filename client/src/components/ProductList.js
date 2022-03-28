import { useState } from 'react';
import classNames from 'classnames';

import './ProductList.scss'

function ProductList({ products, ...props }) {
    return (
        <div className="product-list">
            {products.map(({ sku, name, price, type, ...special }) => {
                return (
                    <Product 
                        key={sku}
                        sku={sku}
                        name={name}
                        price={price}
                        type={type}
                        special={special}
                        shouldDelete={props.setShouldDelete}
                    />
                );
            })}
        </div>
    );
}

function Product({ sku, name, price, type, special, shouldDelete }) {
    const [isChecked, setIsChecked] = useState(false);

    let specialText;

    switch (type) {
        case 'DVD':
            specialText = `Size: ${special.size} MB`;
            break;
        case 'Furniture':
            specialText = `Dimensions: ${special.height}x${special.width}x${special.length}`;
            break;
        case 'Book':
            specialText = `Weight: ${special.weight}KG`;
            break;
        default:
    }

    console.log(specialText);

    return (
        <div className={classNames('product-card', 'shadow', {'marked': isChecked})} 
        onClick={event => shouldDelete(sku, setIsChecked)}>
            <label className="checkbox-label">
                <input type="checkbox" name="" className="delete-checkbox" checked={isChecked} onChange={event => shouldDelete(sku, setIsChecked)}/>
                <span></span>
            </label>
            
            <div>{sku}</div>
            <div><strong>{name}</strong></div>
            <div>{price}</div>
            <div>{specialText}</div>
        </div>
    );
}
export default ProductList;