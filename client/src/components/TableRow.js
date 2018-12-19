import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';
import { withRouter } from 'react-router-dom';

class TableRow extends Component {

  constructor(props) {
        super(props);
        this.delete = this.delete.bind(this);
    }

    async delete() {
        try {
            if (window.confirm(`Are you sure you want to delete ${ this.props.obj.name } ${ this.props.obj.surname }?`)) {
                await axios.delete('http://localhost:81/users/'+this.props.obj.id)
                this.props.history.push('/')
                this.props.history.push('/index')
            }
        }catch(error) {
            console.log(error)
        }
    }
  render() {
    return (
        <tr>
            <td>
                {this.props.obj.name}
            </td>
            <td>
                {this.props.obj.surname}
            </td>
            <td>
                {this.props.obj.telephoneNumber}
            </td>
            <td>
                {this.props.obj.address}
            </td>
            <td>
                <Link to={ '/edit/'+this.props.obj.id } className="btn btn-primary">Edit</Link>
            </td>
            <td>
                <button onClick={ this.delete } className="btn btn-danger">Delete</button>
            </td>
        </tr>
    );
  }
}

export default withRouter(TableRow);