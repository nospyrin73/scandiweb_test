import Header from './components/Header';

function AddProduct() {
    return (
        <>
            <Header label="Product Add">
                <button className="button success">Save</button>
                <button className="button secondary">Cancel</button>
            </Header>
        </>
    );
}

export default AddProduct;