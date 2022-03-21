import Header from './components/Header';
import Footer from './components/Footer';

function Home() {
    return (
        <main className="main">
            <Header label="Product List">
                <button className="button primary">Add</button>
                <button className="button danger">Mass Delete</button>
            </Header>

            <article className="content"></article>

            <Footer />
        </main>
    );
}

export default Home;