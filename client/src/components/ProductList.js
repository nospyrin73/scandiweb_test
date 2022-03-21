import './ProductList.scss'

function ProductList() {
    return (
        <div className="product-list">
            <Product />
            <Product />
            <Product />
            <Product />
            <Product />
            <Product />
            <Product />
            <Product />
            <Product />
            <Product />
            <Product />
        </div>
    );
}

function Product() {
    return (
        <div className="product-card">
            <label className="checkbox-label">
                <input type="checkbox" name="" className="delete-checkbox"/>
                <span></span>
            </label>
            
            <div>JVC200123</div>
            <div>Acme DISC</div>
            <div>1.00 $</div>
            <div>Size: 700 MB</div>
        </div>
    );
}

export default ProductList;