import Header from './components/Header';

function Home() {
    return (
        <>
            <Header label="Product List">
                <button className="button primary">Add</button>
                <button className="button danger">Mass Delete</button>
            </Header>
        </>
    );
}

export default Home;