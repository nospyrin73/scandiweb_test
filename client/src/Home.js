import Header from './components/Header';
import ProductList from './components/ProductList';
import Footer from './components/Footer';

function Home() {
    return (
        <main className="main">
            <Header label="Product List">
                <button className="button primary">Add</button>
                <button className="button danger">Mass Delete</button>
            </Header>

            <article className="content"><ProductList /></article>

            <Footer />
        </main>
    );
}

export default Home;