import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";
import axios from "axios";
import { QueryClient, QueryClientProvider, useQuery } from "react-query";
import { ReactQueryDevtools } from "react-query/devtools";
import InputField from "../components/InputField";
import { Validators } from "../utilities/Validator";
import { CKEditor } from "@ckeditor/ckeditor5-react";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
const queryClient = new QueryClient();

import {
    Col,
    Row,
    Modal,
    ModalHeader,
    ModalBody,
    ModalFooter,
    Button,
    Input,
    Label,
    FormGroup,
} from "reactstrap";
function HelpdeskList() {
    const [modal, setModal] = useState(false);
    const toggle = () => setModal(!modal);
    const [modalsection, setModalsection] = useState(false);
    const toggleSection = () => setModalsection(!modalsection);
    const [isOpenPage, setOpenPage] = useState(false);
    const [isEdit, setIsEdit] = useState(false);
    const [sectionList, setSectionList] = useState([]);
    const [isfilter, setfilter] = useState("");
    const [appname, setappname] = useState([]);
    const [pagesList, setpagesList] = useState([]);
    const [sectionItem, setsectionItem] = useState([]);
    const [addPagebody, setaddPagebody] = useState("");
    const [checked, setchecked] = useState(false);
    const [form, setForm] = useState({
        id: "",
        systemID: "",
        section_name: "",
    });

    const [pageForm, setpageForm] = useState({
        id: "",
        section_id: "",
        page_name: "",
        page_body: "",
        is_publish: "",
    });

    const _systemNameList = () => {
        axios.get("/core/helpdesk/app-name").then((response) => {
            setappname(response.data);
            console.log(response.data);
        });
    };

    const onfilter = (app_id) => {
        setfilter(app_id);
        appname.filter((item) => {
            if (item.id == app_id) {
                setSectionList(item.help_sections);
                form.systemID = item.id;
            }
        });
    };
    const toggleCheck = () => {
        setchecked(!checked);
        setpageForm({
            ...pageForm,
            is_publish: checked ? 0 : 1,
        });
    };
    const onSaveSection = () => {
        axios.post("/core/helpdesk/store-section", form).then((resp) => {
            console.log(resp.data);
            setModal(false);
            _systemNameList();

            onfilter(form.systemID);
        });
    };
    const onSectionHandler = (item) => {
        setsectionItem(item);
        pageForm.section_id = item.id;
        onPageList(item.id);
    };

    const onPageList = (item) => {
        axios
            .get("/core/helpdesk/help-page-section/" + item)
            .then((resp) => {
                setpagesList(resp.data);
                console.log(resp.data);
            })
            .catch((err) => {
                console.log(err);
            });
    };

    const onSectionModalRemove = (item) => {
        setForm(item);
        setModalsection(true);
    };
    const onSectionHandlerRemove = (item) => {
        axios
            .delete("/core/helpdesk/remove-section/" + item)
            .then((resp) => {
                console.log(resp.data);
                setModalsection(false);
                _systemNameList();

                onfilter(item);
            })
            .catch((err) => {
                console.log(err.data);
            });
    };
    const openPageHandler = () => {
        if (sectionItem == "") {
            alert("Please select Section First");
        } else {
            setOpenPage(true);
            setIsEdit(false);
            pageForm.id = "";
            pageForm.page_name = "";
            pageForm.page_body = "";
            setchecked(false);
        }
    };
    const onPageHandler = (item) => {
        axios
            .get("/core/helpdesk/help-pagebyid/" + item.id)
            .then((resp) => {
                console.log(resp.data);

                //setpageForm(resp.data);
                pageForm.id = resp.data.id;
                pageForm.page_name = resp.data.page_name;
                pageForm.page_body = resp.data.page_body;
                pageForm.section_id = resp.data.section_id;
                pageForm.is_publish = resp.data.is_publish;

                // setaddPagebody(resp.data.page_body);
                if (item.is_publish == 0) {
                    setchecked(false);
                } else {
                    setchecked(true);
                }
                setIsEdit(true);
            })
            .catch((err) => {
                console.log(err.data);
            });
    };
    const onPageView = (item) => {
        setOpenPage(true);
        onPageHandler(item);
    };
    const handleChangePageTitle = (e) => {
        setpageForm({
            ...pageForm,
            page_name: e,
        });
    };

    const handleChangePageBody = (e, editor) => {
        const data = editor.getData();
        setaddPagebody(data);

        setpageForm({
            ...pageForm,
            page_body: data,
        });
    };

    const onSavePage = () => {
        if (isEdit == false) {
            axios
                .post("/core/helpdesk/store-page", pageForm)
                .then((res) => {
                    onPageList(pageForm.section_id);
                    console.log(res.data);
                    setOpenPage(false);
                })
                .catch((err) => {
                    console.log(err.data);
                });
        } else if (isEdit == true) {
            axios
                .put("/core/helpdesk/update-page/" + pageForm.id, pageForm)
                .then((res) => {
                    console.log(res.data);
                    setOpenPage(false);
                    onPageList(pageForm.section_id);
                })
                .catch((err) => {
                    console.log(err.data);
                });
        }
    };
    const onDeletePage = (item) => {
        axios
            .delete("/core/helpdesk/delete-page/" + item.id)
            .then((resp) => {
                console.log(resp.data);
                setOpenPage(false);
                onPageList(pageForm.section_id);
            })
            .catch((err) => {
                console.log(err.data);
            });
    };
    const { isLoading, error, data } = useQuery("repoData", _systemNameList, {
        onSuccess: () => console.log("fetch ok"),
    });
    if (isLoading) return "Loading...";

    if (error) return "An error has occurred: " + error.message;

    return (
        <div>
            <div className="card-header">Helpdesk</div>

            <div className="card-body">
                <Row>
                    <Col className="d-flex justify-content-end">
                        <FormGroup className="col-md-3 float-right">
                            <Input
                                type="select"
                                name="select"
                                id="systemID"
                                value={isfilter}
                                onChange={(e) =>
                                    onfilter(e.currentTarget.value)
                                }
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
                <Modal isOpen={modal} toggle={toggle}>
                    <ModalHeader toggle={toggle}>Add Section</ModalHeader>
                    <ModalBody>
                        <FormGroup>
                            <Label for="exampleEmail">Section Name</Label>
                            <Input
                                type="text"
                                name="section_name"
                                value={form.section_name}
                                placeholder=""
                                onChange={(e) =>
                                    setForm({
                                        ...form,
                                        section_name: e.currentTarget.value,
                                    })
                                }
                            />
                        </FormGroup>
                    </ModalBody>
                    <ModalFooter>
                        <Button color="primary" onClick={onSaveSection}>
                            Save
                        </Button>{" "}
                        <Button color="secondary" onClick={toggle}>
                            Cancel
                        </Button>
                    </ModalFooter>
                </Modal>

                {/* modal remove section */}
                <Modal isOpen={modalsection} toggle={toggleSection}>
                    <ModalHeader toggle={toggleSection}>
                        Remove Section
                    </ModalHeader>
                    <ModalBody>
                        <Row>
                            <Label className="ml-3">
                                Are you sure you wish to delete this Section?{" "}
                                {form.section_name}
                            </Label>
                        </Row>
                    </ModalBody>
                    <ModalFooter>
                        <Button
                            color="danger"
                            onClick={() => {
                                onSectionHandlerRemove(form.id);
                            }}
                        >
                            Remove
                        </Button>{" "}
                        <Button color="secondary" onClick={toggleSection}>
                            Cancel
                        </Button>
                    </ModalFooter>
                </Modal>
                {!isOpenPage ? (
                    <Row>
                        <div className="col-md-4 mb-2">
                            <div className="card">
                                <div className="card-header">
                                    Section{" "}
                                    <button
                                        type="button"
                                        className="btn btn-primary btn-sm"
                                        style={{ float: "right" }}
                                        onClick={toggle}
                                    >
                                        +
                                    </button>
                                </div>
                                <div className="card-body">
                                    <div className="list-group">
                                        {sectionList.map((row) => {
                                            return (
                                                <ul
                                                    key={row.id}
                                                    className="list-group"
                                                >
                                                    <li
                                                        className="list-group-item"
                                                        onClick={() => {
                                                            onSectionHandler(
                                                                row
                                                            );
                                                        }}
                                                    >
                                                        <span>
                                                            {row.section_name}
                                                        </span>
                                                        <button
                                                            className="btn btn-default btn-xs pull-right remove-item"
                                                            onClick={() => {
                                                                onSectionModalRemove(
                                                                    row
                                                                );
                                                            }}
                                                        >
                                                            <span className="far fa-trash-alt"></span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            );
                                        })}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div className="col-md-8">
                            <div className="card">
                                <div className="card-header">
                                    Page {sectionItem.section_name}
                                    <button
                                        type="button"
                                        className="btn btn-primary btn-sm"
                                        style={{ float: "right" }}
                                        onClick={openPageHandler}
                                    >
                                        +
                                    </button>
                                </div>
                                <div className="card-body">
                                    <div className="list-group">
                                        {pagesList.map((row) => {
                                            return (
                                                <button
                                                    key={row.id}
                                                    className="list-group-item list-group-item-action"
                                                    onClick={() => {
                                                        onPageView(row);
                                                    }}
                                                >
                                                    {row.page_name}
                                                </button>
                                            );
                                        })}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Row>
                ) : (
                    <Row>
                        <div className="col-md-12">
                            <div className="card">
                                <div className="card-header">
                                    Page {sectionItem.section_name}
                                    <button
                                        type="button"
                                        className="btn btn-primary btn-sm"
                                        style={{ float: "right" }}
                                        onClick={() => setOpenPage(false)}
                                    >
                                        x
                                    </button>
                                </div>
                                <div className="card-body">
                                    <InputField
                                        label="Page Title"
                                        id="page_name"
                                        value={pageForm.page_name}
                                        type="text"
                                        placeholder="Enter Page Title here..."
                                        validators={[
                                            {
                                                check: Validators.required,
                                                message:
                                                    "This field is required",
                                            },
                                        ]}
                                        onChange={(e) => {
                                            handleChangePageTitle(e);
                                        }}
                                    />

                                    <FormGroup>
                                        <Label for="page_body">Page Body</Label>
                                        <CKEditor
                                            name="page_body"
                                            id="page_body"
                                            value={addPagebody}
                                            editor={ClassicEditor}
                                            data={pageForm.page_body}
                                            onChange={handleChangePageBody}
                                        />
                                    </FormGroup>
                                    <FormGroup check>
                                        <Label check>
                                            <Input
                                                onChange={toggleCheck}
                                                id="is_publish"
                                                type="checkbox"
                                                value={checked ? 1 : 0}
                                                checked={checked}
                                            />{" "}
                                            is Active
                                        </Label>
                                    </FormGroup>
                                    <Row>
                                        <Col className="d-flex justify-content-start">
                                            <button
                                                className="btn btn-primary"
                                                onClick={onSavePage}
                                            >
                                                <i className="ti ti-save"></i>{" "}
                                                {isEdit ? "Edit" : "Save"}
                                            </button>
                                        </Col>
                                        <Col className="d-flex justify-content-end">
                                            <button
                                                className="btn btn-danger"
                                                onClick={() => {
                                                    onDeletePage(pageForm);
                                                }}
                                            >
                                                <i className="far fa-trash-alt"></i>{" "}
                                                Remove
                                            </button>
                                        </Col>
                                    </Row>
                                </div>
                            </div>
                        </div>
                    </Row>
                )}
            </div>
        </div>
    );
}
const Helpdesk = () => {
    return (
        <>
            <QueryClientProvider client={queryClient}>
                <HelpdeskList />
            </QueryClientProvider>
        </>
    );
};

export default Helpdesk;

if (document.getElementById("helpdesk")) {
    ReactDOM.render(<Helpdesk />, document.getElementById("helpdesk"));
}
