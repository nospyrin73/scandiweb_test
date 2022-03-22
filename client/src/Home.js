import { Link } from 'react-router-dom';

import Header from './components/Header';
import ProductList from './components/ProductList';
import Footer from './components/Footer';

function Home() {
    return (
        <main className="main">
            <Header label="Product List">
                <Link to="/add-product" className="button primary">Add</Link>
                <button className="button danger">Mass Delete</button>
            </Header>

            <article className="content"><ProductList /></article>

            <Footer />
        </main>
    );
}

export default Home;