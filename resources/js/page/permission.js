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
import axios from "axios";
function PermissionList() {
    const [isOpenModal, setIsOpenModal] = useState(false);
    const [isOpenModalDel, setIsOpenModalDel] = useState(false);
    const toggleModal = () => setIsOpenModal(!isOpenModal);
    const toggleModalDel = () => setIsOpenModalDel(!isOpenModalDel);
    const [isConfirmEditModal, setIsConfirmEditModal] = useState(false);
    const [menuname, setmenuname] = useState([]);
    const [ispermission, setispermission] = useState([]);
    const [isEdit, setIsEdit] = useState(false);
    const [form, setForm] = useState({
        id: "",
        menu_id: "",
        permission_code: "",
        description: "",
        created_by: "",
        update_by: "",
    });

    const _isrefreshList = () => {
        axios
            .get("/core/permission/permission-list")
            .then((response) => {
                setispermission(response.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const _menuTitlelist = () => {
        axios
            .get("/core/permission/menu-list")
            .then((response) => {
                setmenuname(response.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };
    function clearform() {
        setForm({
            ...form,
            id: "",
            menu_id: "",
            permission_code: "",
            description: "",
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
        _menuTitlelist();
        setForm(item);
        setIsOpenModalDel(true);
    };

    const onDelete = (item) => {
        axios
            .delete("/core/permission/delete/" + item)
            .then((response) => {
                setForm({});
                setIsOpenModalDel(false);
                _isrefreshList();
                console.log(response);
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const onSave = () => {
        if (isEdit == false) {
            axios
                .post("/core/permission/store", form)
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
                .put("/core/permission/update/" + form.id, form)
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

    const { data: dataR, error: errorR, loading: landingR } = useQuery(
        "repsData",
        _isrefreshList
    );
    if (landingR) return "Loading...";

    if (errorR) return "An error has occurred: " + errorR.message;
    const { data, error, isLoading } = useQuery(
        "repsDataMenu",
        _menuTitlelist,
        {
            onSuccess: () => console.log("fetch menu"),
        }
    );

    if (isLoading) return "Loading...";

    if (error) return "An error has occurred: " + error.message;

    return (
        <div className="container mt-2">
            {/* modal */}
            <Modal isOpen={isOpenModal} toggle={toggleModal}>
                <ModalHeader toggle={toggleModal}>
                    {isEdit ? "Edit" : "Add"} Permission
                </ModalHeader>
                <ModalBody>
                    <Row>
                        <div className="col-sm">
                            <FormGroup className="col-md-12">
                                <label htmlFor="app_id">Menu Name</label>
                                <Input
                                    type="select"
                                    name="select"
                                    id="menu_id"
                                    value={form.menu_id}
                                    onChange={(e) =>
                                        setForm({
                                            ...form,
                                            menu_id: e.currentTarget.value,
                                        })
                                    }
                                >
                                    {menuname.map((row, key) => {
                                        return (
                                            <option key={key} value={row.id}>
                                                {row.menu_title}
                                            </option>
                                        );
                                    })}
                                </Input>
                            </FormGroup>
                            <FormGroup className="col-md-12">
                                <Label for="App Icon">Permisson</Label>
                                <Input
                                    id="app_icon"
                                    value={form.permission_code}
                                    onChange={(e) => {
                                        setForm({
                                            ...form,
                                            permission_code: e.target.value,
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
                        </div>
                    </Row>
                </ModalBody>
                <ModalFooter>
                    <Button color="primary" onClick={onSave}>
                        {isEdit ? "Edit" : "Add"} Permission
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
                            {form.menu_title}
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
                Add Permission
            </Button>

            <Row>
                <div className="col-md-12">
                    <Table className="table table-striped table-hover table-sm table-responsive-lg">
                        <thead>
                            <tr>
                                <th scope="col">Menu Name</th>
                                <th scope="col">Permission</th>
                                <th scope="col">Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {ispermission.map((row) => {
                                return (
                                    <tr key={row.id}>
                                        <th>{row.menu_title}</th>
                                        <th>{row.permission_code}</th>
                                        <th>{row.description}</th>

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
const Permission = () => {
    return (
        <>
            <QueryClientProvider client={queryClient}>
                <PermissionList />
            </QueryClientProvider>
        </>
    );
};

export default Permission;

if (document.getElementById("permission")) {
    ReactDOM.render(<Permission />, document.getElementById("permission"));
}
