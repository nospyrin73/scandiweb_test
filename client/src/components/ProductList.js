import { useState, useEffect, useRef } from 'react';
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
                        addRef={props.addRef}
                    />
                );
            })}
        </div>
    );
}

function Product({ sku, name, price, type, special, shouldDelete, addRef }) {
    const [isChecked, setIsChecked] = useState(false);
    const checkbox = useRef(null);

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

    useEffect(() => {
        addRef(sku, checkbox);
    }, [sku, addRef]);

    return (
        <div className={classNames('product-card', 'shadow', {'marked': isChecked})} 
        onClick={event => shouldDelete(sku, setIsChecked, checkbox.current)}>
            <label className="checkbox-label">
                <input 
                    type="checkbox"
                    name="checkbox" 
                    className="delete-checkbox"
                    defaultChecked={isChecked}
                    onChange={event => {console.log('on change...');}}
                    ref={checkbox}/>
                <span></span>
            </label>
            
            <div>{sku}</div>
            <div><strong>{name}</strong></div>
            <div>{price} $</div>
            <div>{specialText}</div>
        </div>
    );
}
export default ProductList;