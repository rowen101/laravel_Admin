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
    Container,
    Col,
} from "reactstrap";

function ApplicaitonList() {
    const [isOpenModal, setIsOpenModal] = useState(false);
    const [isOpenModalDel, setIsOpenModalDel] = useState(false);
    const toggleModal = () => setIsOpenModal(!isOpenModal);
    const toggleModalDel = () => setIsOpenModalDel(!isOpenModalDel);
    const [isConfirmEditModal, setIsConfirmEditModal] = useState(false);
    const [applicaton, setApplication] = useState([]);
    const [isEdit, setIsEdit] = useState(false);
    const [form, setForm] = useState({
        id: "",
        app_code: "",
        app_name: "",
        description: "",
        app_icon: "",
        status: "",
        status_message: "",
        created_by: "",
        update_by: "",
    });

    const _isrefreshList = () => {
        axios
            .get("/core/application/app-list")
            .then((response) => {
                setApplication(response.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };
    function clearform() {
        setForm({
            ...form,
            app_code: "",
            id: "",
            app_name: "",
            description: "",
            app_icon: "",
            status: "",
            status_message: "",
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
    };

    const onOpenDelModal = (item) => {
        setForm(item);
        setIsOpenModalDel(true);
    };

    const onDelete = (item) => {
        axios.delete("/core/application/delete/" + item).then((response) => {
            setForm({});
            setIsOpenModalDel(false);
            _isrefreshList();
        });
    };
    const onSave = () => {
        if (isEdit == false) {
            axios
                .post("/core/application/store", form)
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
                .put("/core/application/update/" + form.id, form)
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
                    {isEdit ? "Edit" : "Add"} Application
                </ModalHeader>
                <ModalBody>
                    <Row>
                        <Col>
                            <Row>
                                <FormGroup className="col-md-6 ">
                                    <Label for="App Code">App Code</Label>
                                    <Input
                                        id="app_code"
                                        value={form.app_code}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                app_code: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                                <FormGroup className="col-md-6 ">
                                    <Label for="App Name">App Name</Label>
                                    <Input
                                        id="app_name"
                                        value={form.app_name}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                app_name: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                            </Row>
                            <FormGroup>
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
                            <FormGroup>
                                <Label for="App Icon">App Icon</Label>
                                <Input
                                    id="app_icon"
                                    value={form.app_icon}
                                    onChange={(e) => {
                                        setForm({
                                            ...form,
                                            app_icon: e.target.value,
                                        });
                                    }}
                                />
                            </FormGroup>
                            <FormGroup>
                                <Label for="Status">tatus</Label>
                                <Input
                                    type="select"
                                    name="select"
                                    id="status"
                                    value={form.status}
                                    onChange={(e) => {
                                        setForm({
                                            ...form,
                                            status: e.target.value,
                                        });
                                    }}
                                >
                                    <option value="active">Active</option>
                                    <option value="inactive">inactive</option>
                                </Input>
                            </FormGroup>
                            {/* <FormGroup>
                                <Label for="Status">Status</Label>
                                <Input
                                    id="status"
                                    value={form.status}
                                    onChange={(e) => {
                                        setForm({
                                            ...form,
                                            status: e.target.value,
                                        });
                                    }}
                                />
                            </FormGroup> */}
                            <FormGroup>
                                <Label for="Status Message">
                                    Status Message
                                </Label>
                                <Input
                                    id="status_message"
                                    value={form.status_message}
                                    onChange={(e) => {
                                        setForm({
                                            ...form,
                                            status_message: e.target.value,
                                        });
                                    }}
                                />
                            </FormGroup>
                        </Col>
                    </Row>
                </ModalBody>
                <ModalFooter>
                    <Button color="primary" onClick={onSave}>
                        {isEdit ? "Edit" : "Add"} Application
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
                    Delete Application
                </ModalHeader>
                <ModalBody>
                    <Row>
                        <Label className="ml-3">
                            Are you sure you wish to delete this item?{" "}
                            {form.app_name}
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
                Add Application
            </Button>

            <Row>
                <div className="col-md-12">
                    <Table className="table table-striped table-hover table-sm table-responsive-lg">
                        <thead>
                            <tr>
                                <th scope="col">App Code</th>
                                <th scope="col">App Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {applicaton.map((row) => {
                                return (
                                    <tr key={row.id}>
                                        <th>{row.app_code}</th>
                                        <th>{row.app_name}</th>
                                        <th>{row.description}</th>
                                        <th>{row.status}</th>
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
const Application = () => {
    return (
        <>
            <QueryClientProvider client={queryClient}>
                <ApplicaitonList />
            </QueryClientProvider>
        </>
    );
};

export default Application;

if (document.getElementById("apps")) {
    ReactDOM.render(<Application />, document.getElementById("apps"));
}
