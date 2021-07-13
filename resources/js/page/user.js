import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import { QueryClient, QueryClientProvider, useQuery } from "react-query";
import { ReactQueryDevtools } from "react-query/devtools";
const queryClient = new QueryClient();

import {
    Label,
    Input,
    FormGroup,
    ModalFooter,
    ModalBody,
    ModalHeader,
    Modal,
    Table,
    Button,
    Row,
    Col,
} from "reactstrap";

function UserList() {
    const [isOpenModal, setIsOpenModal] = useState(false);
    const [isOpenModalDel, setIsOpenModalDel] = useState(false);
    const toggleModal = () => setIsOpenModal(!isOpenModal);
    const toggleModalDel = () => setIsOpenModalDel(!isOpenModalDel);
    const [isConfirmEditModal, setIsConfirmEditModal] = useState(false);
    const [User, setUser] = useState([]);
    const [isEdit, setIsEdit] = useState(false);
    const [role, setrole] = useState([]);
    const [checked, setchecked] = useState(false);
    const [form, setForm] = useState({
        id: "",
        uuid: "",
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        user_type: "",
        role_id: "",
        first_name: "",
        last_name: "",
        language: "",
        is_active: "",
    });

    const _isrefreshList = () => {
        axios
            .get("/core/user/user-list")
            .then((response) => {
                setUser(response.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };

    const _roleUserList = () => {
        axios
            .get("/core/user/role")
            .then((response) => {
                setrole(response.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };
    function clearform() {
        setForm({
            ...form,
            id: "",
            uuid: "",
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            user_type: "",
            role_id: "",
            first_name: "",
            last_name: "",
            language: "",
            is_active: "" ? setchecked(true) : setchecked(false),
        });
    }
    const AddOpenModal = () => {
        setIsOpenModal(true);
        setIsEdit(false);
        clearform();
    };
    const onEdit = (item) => {
        setForm(item);
        setIsOpenModal(true);
        setIsEdit(true);
    };

    const onDelete = (item) => {
        axios.delete("/core/user/update/" + item).then(() => {
            setForm({});
            setIsOpenModalDel(false);
            _isrefreshList();
        });
    };
    //  delete modal
    const onOpenDelModal = (item) => {
        setForm(item);
        setIsOpenModalDel(true);
    };

    const onSave = () => {
        if (isEdit == false) {
            axios
                .post("/core/user/register", form)
                .then(() => {
                    setForm({});
                    setIsOpenModal(false);
                    _isrefreshList();
                })
                .catch((err) => {
                    console.log(err.data);
                });
        } else if (isEdit == true) {
            axios
                .put("/core/user/update/" + form.id, form)
                .then(() => {
                    setForm({});
                    setIsOpenModal(false);
                    _isrefreshList();
                })
                .catch((err) => {
                    console.log(err.data);
                });
        }
    };
    const toggle = () => {
        setchecked(!checked);
        setForm({
            ...form,
            is_active: checked ? 0 : 1,
        });
    };

    const { data: dataR } = useQuery("repsData", _isrefreshList);

    const { data } = useQuery("repsDataRole", _roleUserList);

    return (
        <div className="container mt-2">
            {/* modal */}
            <Modal isOpen={isOpenModal} toggle={toggleModal}>
                <ModalHeader toggle={toggleModal}>
                    {isEdit ? "Edit" : "Add"} User
                </ModalHeader>
                <ModalBody>
                    <Row>
                        <Col>
                            <Row>
                                <FormGroup className="col-md-6">
                                    <Label for="First Name">First Name</Label>
                                    <Input
                                        id="first_name"
                                        value={form.first_name}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                first_name: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                                <FormGroup className="col-md-6">
                                    <Label for="Last Name">Last Name</Label>
                                    <Input
                                        id="last_name"
                                        value={form.last_name}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                last_name: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                            </Row>
                            <Row>
                                <FormGroup className="col-md-6">
                                    <Label for="Name">User Name</Label>
                                    <Input
                                        id="name"
                                        value={form.name}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                name: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                                <FormGroup className="col-md-6">
                                    <Label for="usertype">User Type</Label>
                                    <Input
                                        id="usertype"
                                        value={form.usertype}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                usertype: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                                {/* <FormGroup className="col-md-6">
                                    <Label for="Email">Email</Label>
                                    <Input
                                        id="email"
                                        value={form.email}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                email: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup> */}
                            </Row>
                            {/* <Row>
                                <FormGroup className="col-md-6">
                                    <Label for="password">Password</Label>
                                    <Input
                                        id="password"
                                        value={form.password}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                password: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                                <FormGroup className="col-md-6">
                                    <Label for="password_confirmation">
                                        Cc Password
                                    </Label>
                                    <Input
                                        id="password_confirmation"
                                        value={form.password_confirmation}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                password_confirmation:
                                                    e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                            </Row> */}
                            <Row>
                                <FormGroup className="col-md-6">
                                    <label htmlFor="role_id">Role</label>
                                    <Input
                                        type="select"
                                        name="select"
                                        id="role_id"
                                        value={form.role_id}
                                        onChange={(e) =>
                                            setForm({
                                                ...form,
                                                role_id: e.currentTarget.value,
                                            })
                                        }
                                    >
                                        {role.map((row, key) => {
                                            return (
                                                <option
                                                    key={key}
                                                    value={row.id}
                                                >
                                                    {row.role_code}
                                                </option>
                                            );
                                        })}
                                    </Input>
                                </FormGroup>
                            </Row>
                            <FormGroup check>
                                <Label check>
                                    <Input
                                        onChange={toggle}
                                        id="is_active"
                                        type="checkbox"
                                        value={checked ? 1 : 0}
                                        checked={checked}
                                    />{" "}
                                    is Active
                                </Label>
                            </FormGroup>
                            <br />
                        </Col>
                    </Row>
                </ModalBody>
                <ModalFooter>
                    <Button color="primary" onClick={onSave}>
                        {isEdit ? "Edit" : "Add"} Menu
                    </Button>
                    <Button color="secondary" onClick={toggleModal}>
                        Cancel
                    </Button>
                </ModalFooter>
            </Modal>
            {/* end modal */}

            {/* delete modal */}
            <Modal
                isOpen={isOpenModalDel}
                toggle={toggleModalDel}
                className="fades"
            >
                <ModalHeader toggle={toggleModalDel}>Delete User</ModalHeader>
                <ModalBody>
                    <Row>
                        <Label className="ml-3">
                            Are you sure you wish to delete this item?{" "}
                            {form.name}
                        </Label>
                    </Row>
                </ModalBody>
                <ModalFooter>
                    <Button
                        color="primary"
                        onClick={() => {
                            onDelete(form.id);
                        }}
                    >
                        Delete
                    </Button>
                    <Button color="secondary" onClick={toggleModalDel}>
                        Cancel
                    </Button>
                </ModalFooter>
            </Modal>
            {/* end delete modal */}
            <Button
                color="primary"
                size="sm"
                className="mr-2 mb-2"
                onClick={AddOpenModal}
            >
                Add User
            </Button>

            <Row>
                <div className="col-md-12">
                    <Table className="table table-striped table-hover table-sm table-responsive-lg ">
                        <thead>
                            <tr>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {User.map((row) => {
                                return (
                                    <tr key={row.id}>
                                        <th>{row.first_name}</th>
                                        <th>{row.last_name}</th>
                                        <th>{row.email}</th>

                                        <th>
                                            <Button
                                                color="success"
                                                size="sm"
                                                className="mr-1"
                                                onClick={() => {
                                                    onEdit(row);
                                                }}
                                            >
                                                <i className="ti-pencil"></i>{" "}
                                                Edit
                                            </Button>
                                            |{" "}
                                            <Button
                                                color="danger"
                                                size="sm"
                                                className="ml"
                                                onClick={() => {
                                                    onOpenDelModal(row);
                                                }}
                                            >
                                                <i className="ti-trash"></i>
                                                Remove
                                            </Button>
                                        </th>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </Table>
                </div>
            </Row>
        </div>
    );
}
const User = () => {
    return (
        <>
            <QueryClientProvider client={queryClient}>
                <UserList />
            </QueryClientProvider>
        </>
    );
};

export default User;

if (document.getElementById("user")) {
    ReactDOM.render(<User />, document.getElementById("user"));
}
