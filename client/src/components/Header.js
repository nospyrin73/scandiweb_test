import './Header.scss'

function Header({ children, label }) {
    return (
        <header className="header">
            <section className="label">
                <h1>{label}</h1>
            </section>
            <section className="actions">
                {children}
            </section>
        </header>
    );
}

export default Header;