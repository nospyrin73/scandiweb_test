import classNames from 'classnames';

import './Notification.scss'

function Notification({ alert, setAlert }) {
    return (
        <div className={classNames('notification', alert.className)} >
            <span>{alert.message}</span>
            <span className="cross" onClick={() => setAlert(null)}>&#10006;</span>
        </div>
    );
}

export default Notification;