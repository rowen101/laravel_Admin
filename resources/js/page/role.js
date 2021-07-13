import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
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
} from "reactstrap";

function RoleList() {
    const [isOpenModal, setIsOpenModal] = useState(false);
    const [isOpenModalDel, setIsOpenModalDel] = useState(false);
    const toggleModal = () => setIsOpenModal(!isOpenModal);
    const toggleModalDel = () => setIsOpenModalDel(!isOpenModalDel);
    const [checked, setchecked] = useState(false);

    const [isRole, setRole] = useState([]);
    const [isEdit, setIsEdit] = useState(false);
    const [form, setForm] = useState({
        id: "",
        role_code: "",
        description: "",
        is_active: "",
    });

    const _isrefreshList = () => {
        axios.get("/core/role/role-list").then((response) => {
            setRole(response.data);
        });
    };
    function clearform() {
        setForm({
            ...form,
            id: "",
            role_code: "",
            description: "",
            is_active: "" ? setchecked(true) : setchecked(false),
        });
    }
    const AddOpenModal = () => {
        setIsOpenModal(true);
        setIsEdit(false);
        clearform();
    };
    const onEditModal = (item) => {
        setForm(item);
        setIsOpenModal(true);
        setIsEdit(true);
        if (item.is_active == 0) {
            setchecked(false);
        } else {
            setchecked(true);
        }
    };

    //  delete modal
    const onOpenDelModal = (item) => {
        setForm(item);
        setIsOpenModalDel(true);
    };

    const onDelete = (item) => {
        axios.delete("/core/role/delete/" + item).then((response) => {
            setForm({});
            setIsOpenModalDel(false);
            _isrefreshList();
        });
    };
    const onSave = () => {
        if (isEdit == false) {
            axios
                .post("/core/role/store", form)
                .then(() => {
                    setForm({});
                    setIsOpenModal(false);
                    _isrefreshList();
                })
                .catch((err) => {
                    console.log(err.data);
                });
        } else {
            axios
                .put("/core/role/update/" + form.id, form)
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
    const { isLoading, error, data } = useQuery("repsData", _isrefreshList, {
        onSuccess: () => console.log("fetch ok"),
    });
    if (isLoading) return "Loading...";

    if (error) return "An error has occurred: " + error.message;

    return (
        <div className="container mt-2">
            {/* modal */}
            <Modal isOpen={isOpenModal} toggle={toggleModal}>
                <ModalHeader toggle={toggleModal}>
                    {isEdit ? "Edit" : "Add"} Role
                </ModalHeader>
                <ModalBody>
                    <Row>
                        <div className="col-sm">
                            <FormGroup className="col-md-12">
                                <Label for="App Icon">Role Code</Label>
                                <Input
                                    id="role_code"
                                    value={form.role_code}
                                    onChange={(e) => {
                                        setForm({
                                            ...form,
                                            role_code: e.target.value,
                                        });
                                    }}
                                />
                            </FormGroup>
                            <FormGroup className="col-md-12">
                                <Label for="Description">Description</Label>
                                <Input
                                    id="description"
                                    value={form.description}
                                    onChange={(e) => {
                                        setForm({
                                            ...form,
                                            description: e.target.value,
                                        });
                                    }}
                                />
                            </FormGroup>
                            <FormGroup check className="ml-3">
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
                        </div>
                    </Row>
                </ModalBody>
                <ModalFooter>
                    <Button color="primary" onClick={onSave}>
                        {isEdit ? "Edit" : "Add"} Role
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
                <ModalHeader toggle={toggleModalDel}>
                    Delete Permission
                </ModalHeader>
                <ModalBody>
                    <Row>
                        <Label className="ml-3">
                            Are you sure you wish to delete this item?{" "}
                            {form.role_code}
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
                Add Role
            </Button>

            <Row>
                <div className="col-md-12">
                    <Table className="table table-striped table-hover table-sm table-responsive-lg">
                        <thead>
                            <tr>
                                <th scope="col">Role Code</th>
                                <th scope="col">Description</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {isRole.map((row) => {
                                return (
                                    <tr key={row.id}>
                                        <th>{row.role_code}</th>
                                        <th>{row.description}</th>
                                        <th>
                                            <i
                                                className={
                                                    row.is_active == 1
                                                        ? "fas fa-check-circle"
                                                        : "far fa-circle"
                                                }
                                            ></i>
                                        </th>
                                        <th>
                                            <Button
                                                color="success"
                                                size="sm"
                                                className="mr-1"
                                                onClick={() => {
                                                    onEditModal(row);
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
const Role = () => {
    return (
        <>
            <QueryClientProvider client={queryClient}>
                <RoleList />
            </QueryClientProvider>
        </>
    );
};

export default Role;

if (document.getElementById("role")) {
    ReactDOM.render(<Role />, document.getElementById("role"));
}
