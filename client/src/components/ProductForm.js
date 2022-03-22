import { useState } from 'react';

const defaultValues = {
    sku: '', name: '', price: '',
    size: '',
    height: '', width: '', length: '',
    weight: ''
};

function ProductForm() {
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
    }

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
                    <select value={type} onChange={switchType}>
                        <option id="default"> -- select an option -- </option>
                        <option id="DVD">DVD</option>
                        <option id="Furniture">Furniture</option>
                        <option id="Book">Book</option>
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