import { Routes, Route } from 'react-router-dom';

import Home from './Home';
import AddProduct from './AddProduct';

function App() {
    return (
        <Routes>
            <Route path="/" element={<Home />}/>
            <Route path="/add-product" element={<AddProduct />}/>
        </Routes>
    );
}

export default App;
