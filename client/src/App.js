import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import { BrowserRouter as Router, Switch, Route, Link } from 'react-router-dom';

import Create from './components/create.component';
import Edit from './components/edit.component';
import Index from './components/index.component';

class App extends Component {
  
  render() {
    return (
    
        <Router>
            <div className="container">
                <nav className="navbar navbar-expand-lg navbar-light bg-light">
                    <Link to={ '/index' } className="navbar-brand">Users CRUD</Link>
                    <div className="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul className="navbar-nav mr-auto">
                        </ul>
                    </div>
                </nav> <br/>
                <br/>
                <Switch>
                    <Route exact path='/index' component={ Index } />
                    <Route exact path='/create' component={ Create } />
                    <Route path='/edit/:id' component={ Edit } />
                </Switch>
            </div>
        </Router>
    );
  }
}

export default App;