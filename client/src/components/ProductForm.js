
function ProductForm({ values, type, handleChange, switchType }) {
    const types = {
        DVD: (
            <div>
                <label>
                    <span>Size (MB)</span>
                    <input type="text" name="size" id="size" 
                    onChange={handleChange} value={values.size}/>
                </label>
                <p>Please provide size in MB</p>
            </div>
        ),
        Furniture: (
            <div>
                <label>
                    <span>Height (CM)</span>
                    <input type="text" name="height" id="height" 
                    onChange={handleChange} value={values.height}/>
                </label>
                <label>
                    <span>Width (CM)</span>
                    <input type="text" name="width" id="width" 
                    onChange={handleChange} value={values.width}/>
                </label>
                <label>
                    <span>Length (CM)</span>
                    <input type="text" name="length" id="length" 
                    onChange={handleChange} value={values.length}/>
                </label>
                <p>Please provide dimensions HxWxL format</p>
            </div>
        ),
        Book: (
            <div>
                <label>
                    <span>Weight (KG)</span>
                    <input type="text" name="weight" id="weight" 
                    onChange={handleChange} value={values.weight}/>
                </label>
                <p>Please provide weight in Kg unit</p>
            </div>
        )
    };

    return (
        <form id="product_form">
            <section>
                <label>
                    <span>SKU</span>
                    <input type="text" name="sku" id="sku" 
                    onChange={handleChange} value={values.sku}/>
                </label>

                <label>
                    <span>Name</span>
                    <input type="text" name="name" id="name" 
                    onChange={handleChange} value={values.name}/>
                </label>

                <label>
                    <span>Price</span>
                    <input type="text" name="price" id="price" 
                    onChange={handleChange} value={values.price}/>
                </label>

                <label>
                    <span>Type Switcher</span>
                    <select onChange={switchType} defaultValue="default">
                        <option value="default" disabled> -- select an option -- </option>
                        <option>DVD</option>
                        <option>Furniture</option>
                        <option>Book</option>
                    </select>
                </label>
            </section>
            <section>
                {types[type]}
            </section>
        </form>
    );
}

export default ProductForm;