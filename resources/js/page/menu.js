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

function MenuList() {
    const [isOpenModal, setIsOpenModal] = useState(false);
    const [isOpenModalDel, setIsOpenModalDel] = useState(false);
    const toggleModal = () => setIsOpenModal(!isOpenModal);
    const toggleModalDel = () => setIsOpenModalDel(!isOpenModalDel);
    const [isConfirmEditModal, setIsConfirmEditModal] = useState(false);
    const [menu, setMenu] = useState([]);
    const [isfilter, setfilter] = useState("");
    const [isEdit, setIsEdit] = useState(false);
    const [appname, setappname] = useState([]);
    const [appItemName, setappItemName] = useState("");
    const [checked, setchecked] = useState(false);
    const [form, setForm] = useState({
        id: "",
        uuid: "",
        app_id: "",
        menu_code: "",
        menu_title: "",
        description: "",
        parent_id: "",
        menu_icon: "",
        menu_route: "",
        sort_order: "",
        is_active: "",
        created_by: "",
        updated_by: "",
    });

    const _isrefreshList = () => {
        axios
            .get("/core/menu/menu-list")
            .then((response) => {
                setappname(response.data);
                console.log(response.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };
    const onfilter = (app_id) => {
        setfilter(app_id);
        appname.filter((item) => {
            if (item.id == app_id) {
                setMenu(item.menus);
                form.app_id = item.id;
                setappItemName(item.app_name);
            }
        });
    };

    function clearform() {
        setForm({
            ...form,
            id: "",
            uuid: "",
            app_id: "",
            menu_code: "",
            menu_title: "",
            description: "",
            parent_id: "",
            menu_icon: "",
            menu_route: "",
            sort_order: "",
            is_active: "" ? setchecked(true) : setchecked(false),
        });
    }
    const AddOpenModal = () => {
        if (appItemName == "") {
            alert("Please select application First");
        } else {
            setIsOpenModal(true);
            setIsEdit(false);
            clearform();
        }
    };
    const onEdit = (item) => {
        setForm(item);
        setIsOpenModal(true);
        setIsEdit(true);
        if (item.is_active == 0) {
            setchecked(false);
        } else {
            setchecked(true);
        }
    };

    const onDelete = (item) => {
        axios
            .delete("/core/menu/delete/" + item)
            .then(() => {
                setForm({});
                setIsOpenModalDel(false);
                _isrefreshList();
            })
            .catch((err) => {
                console.log(err);
            });
    };

    const onOpenDelModalDel = (item) => {
        setIsOpenModalDel(true);
    };

    const onSave = () => {
        if (isEdit == false) {
            axios
                .post("/core/menu/store", form)
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
                .put("/core/menu/update/" + form.id, form)
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
                    {isEdit ? "Edit" : "Add"} Menu to {appItemName}
                </ModalHeader>
                <ModalBody>
                    <Row>
                        <Col>
                            <Row>
                                <FormGroup className="col-md-6">
                                    <Label for="Menu Code">Menu Code</Label>
                                    <Input
                                        id="menu_code"
                                        value={form.menu_code}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                menu_code: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                                <FormGroup className="col-md-6">
                                    <Label for="menu_title">Menu Title</Label>
                                    <Input
                                        id="menu_title"
                                        value={form.menu_title}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                menu_title: e.target.value,
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
                            <Row>
                                <FormGroup className="col-md-6">
                                    <Label for="parent_id">Parent ID</Label>
                                    <Input
                                        type="number"
                                        id="parent_id"
                                        value={form.parent_id}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                parent_id: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                                <FormGroup className="col-md-6">
                                    <Label for="menu_icon">Menu Icon</Label>
                                    <Input
                                        id="menu_icon"
                                        value={form.menu_icon}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                menu_icon: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>
                            </Row>

                            <Row>
                                <FormGroup className="col-md-6">
                                    <Label for="menu_route">Menu Route</Label>
                                    <Input
                                        id="menu_route"
                                        value={form.menu_route}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                menu_route: e.target.value,
                                            });
                                        }}
                                    />
                                </FormGroup>

                                <FormGroup className="col-md-6">
                                    <Label for="sort_order">Sort Order</Label>
                                    <Input
                                        id="sort_order"
                                        value={form.sort_order}
                                        onChange={(e) => {
                                            setForm({
                                                ...form,
                                                sort_order: e.target.value,
                                            });
                                        }}
                                    />
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
                <ModalHeader toggle={toggleModalDel}>
                    Delete Application
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
            <Row className="d-flex justify-content-between">
                <Col className="col-md-6">
                    <Button
                        color="primary"
                        size="sm"
                        className="mr-2 mb-2"
                        onClick={AddOpenModal}
                    >
                        Add Menu
                    </Button>
                </Col>

                <Col className="col-md-6 ">
                    <FormGroup className="col-md-7 float-right">
                        <Input
                            type="select"
                            name="select"
                            id="app_id"
                            value={isfilter}
                            onChange={(e) => onfilter(e.currentTarget.value)}
                        >
                            {appname.map((row, key) => {
                                return (
                                    <option key={key} value={row.id}>
                                        {row.app_name}
                                    </option>
                                );
                            })}
                        </Input>
                    </FormGroup>
                </Col>
            </Row>

            <Row>
                <div className="col-md-12">
                    <Table className="table table-striped table-hover table-sm table-responsive-lg ">
                        <thead>
                            <tr>
                                <th scope="col">Menu Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {menu.map((row) => {
                                return (
                                    <tr key={row.id}>
                                        <th>{row.menu_title}</th>
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
                                                    onOpenDelModalDel(row);
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
const Menu = () => {
    return (
        <>
            <QueryClientProvider client={queryClient}>
                <MenuList />
            </QueryClientProvider>
        </>
    );
};

export default Menu;

if (document.getElementById("menu")) {
    ReactDOM.render(<Menu />, document.getElementById("menu"));
}
