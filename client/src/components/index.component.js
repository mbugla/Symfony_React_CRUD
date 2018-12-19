import React, { Component } from 'react';
import axios from 'axios';
import TableRow from './TableRow';
import { Link } from 'react-router-dom';

export default class Index extends Component {

  constructor(props) {
      super(props);
      this.state = { users: null };
    }

    async componentDidMount(){
        try {
            const response = await axios.get('http://localhost:81/users')

            this.setState({ users: response.data });
        } catch (error) {
            console.log(error);
        }
    }

    tabRow(){
      return this.state.users.map(function(object, i){
          return <TableRow obj={ object } key={ i } />;
      });
    }

    createButton() {
        return <Link to={ '/create' } className="btn btn-success">Add User</Link>;
    }

    render() {
        if(!this.state.users) {
            return (
                <div>
                    <h3 align="center">Users List</h3>
                    <div>Loading...</div>
                </div>
            );
        } else if(this.state.users.length === 0) {
            return (
                <div>
                    <h3 align="center">Users List</h3>
                    <div> No users in system.</div>
                    <br></br>
                    <div>
                        {this.createButton()}
                    </div>
                </div>
                
                );
        }
         else {
      return (
          <div>
              <h3 align="center">Users List</h3>
       
              <table className="table table-striped" style={ { marginTop: 20 } }>
                  <thead>
                      <tr>
                          <th>Name</th>
                          <th>Surname</th>
                          <th>Telephone Number</th>
                          <th>Address</th>
                          <th colSpan="2">Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      { this.tabRow() }
                  </tbody>
              </table>
              <div>
                  {this.createButton()}
              </div>
          </div>
       
      );
    }
    }
  }