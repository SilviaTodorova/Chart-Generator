
  
// Global letiables  
let count = 1;

let student_structure;
let categories;
let studentIds;
let fullData;
let genders;

let boxChart;
let hw1;
let type_chart;
let url;

form = document.querySelector('form');
formData = new FormData(form);

document.addEventListener('DOMContentLoaded', function() {
    url = document.getElementById("url").value;

    // Load Data
    // All student data

    postData(url+'student/all').then(function(result) {
        fillData(result);
    });

    // All chart stored in database
    postData(url+'chart/getAll').then(function(result) {
        result.forEach(x => {
            addRow('charts', x);
        });         
    });
    
    // Manage table (coordinates x & y)
    // Add y coordinates to table
	document.getElementById('add-data').addEventListener('click', function(){
        event.preventDefault();
        if(count < 3) {
            createColumnData();
        }
    });

    // Delete y coordinates from table
    document.getElementById('delete-data').addEventListener('click', function(){
        event.preventDefault();
        if(count > 1) {
            deleteColumnData();
        }
    });

    // DropDowns Multiple (All student's fn)
    document.getElementById('all-student').addEventListener('change', function(event){
        // Fill textbox  
        let labels = [];
        let collection = document.getElementById('all-student').selectedOptions;
        for (let i=0; i<collection.length; i++) {
            labels.push(collection[i].label);
        }

        data = document.getElementById('x-data');
        fillTextBox(data, labels);
    });

    // DropDowns x-coordinates (all, group students and gender choice)
    document.getElementById('x-coord').addEventListener('change', function(event){
        let data = document.getElementById('x-data');

        // Clear y coordinates
        document.getElementById('y-data-1').innerHTML = '';

        if(document.getElementById('y-data-2') != undefined) {
            document.getElementById('y-data-2').innerHTML = '';
        }
        
        if(event.target.value == 1) {
            // All Students
            // Hide multiple dropdown
            document.getElementById('all-student').style.display = 'none';
            document.getElementById('x-data').innerHTML = '';
            fillTextBox(data, studentIds);

        } else if(event.target.value == 2) {
            // Group
            // Show multiple dropdown
            document.getElementById('all-student').style.display = 'block';
            document.getElementById('x-data').innerHTML = '';

            // Fill text 
            let fns = [];
            let collection = document.getElementById('all-student').selectedOptions;
            for (let i=0; i<collection.length; i++) {
                fns.push(collection[i].label);
            }

            fillTextBox(data, fns);

        } else if(event.target.value == 3) {
            // Gender
            // Hide multiple dropdown
            document.getElementById('all-student').style.display = 'none';
            document.getElementById('x-data').innerHTML = '';

            fillTextBox(data, genders);
        }
        
    });

    // Modals
    let modalPreview = document.getElementById('preview-chart');

    // Open
    document.getElementById('open-preview-chart').addEventListener('click', function(event) {
        event.preventDefault();

        modalPreview.style.display = 'block';  
        form = document.querySelector('form');
        formData = new FormData(form);

        let type = formData.get('type');
        let labels = [];
        let selected = document.getElementById('x-coord').value;

        if(selected == 1) {
            // All
            labels = studentIds;
        } else if(selected == 2) {
            // Group Students
            let collection = document.getElementById('all-student').selectedOptions;
            for (let i=0; i<collection.length; i++) {
                labels.push(collection[i].label);
            }

        } else if(selected == 3) {
            // Gender
            labels = genders;
        }

        let data = []; 
        let options = {};

        if (type == 'bar' || type == 'horizontalBar') {
            showGrid = true;
            
            for (let i = 1; i < count; i++) {
                let tmp = {
                    label: formData.get('y-label-'+i), 
                    data: getDropDownData('y-dropdown-'+i),
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    
                };
                data.push(tmp);
            }

            data = {
                labels: labels,
                datasets: data
            };

            options = {
                title: {
                  display: true,
                  text: formData.get('title')
                }, scales: {
                  yAxes: [{ 
                    scaleLabel: {
                      display: true,
                      labelString: formData.get('y-title')
                    },
                    ticks: {
                        min: parseInt(formData.get('min-y'), 0),
                        max: parseInt(formData.get('max-y'), 0),
                        stepSize: parseInt(formData.get('step'), 0),
                    }
                  }],
                  xAxes: [{ 
                    scaleLabel: {
                      display: true,
                      labelString: formData.get('x-title')
                    }
                  }]
                },
                animation: {
                    onComplete: done
                }
              };
              
        } else if (type == 'pie' || type == 'doughnut' || type == 'line' || type == 'radar') {

            for (let i = 1; i < count; i++) {
                let tmp = {
                    data: getDropDownData('y-dropdown-'+i),
                    backgroundColor: [  
                        'rgb(255, 99, 132)',
                        'rgb(255, 159, 64)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgb(153, 102, 255)',
                        'rgb(201, 203, 207)'
                     ]
                    
                };
                data.push(tmp);
            }

            data = {
                labels: labels,
                datasets: data
            };

            options = {
                title: {
                  display: true,
                  text: formData.get('title')
                },
                animation: {
                    onComplete: done
                }
              };
        }
        // else if (type == 'line') {

        // }

       

          function done(){
            let url = boxChart.toBase64Image();  
            document.getElementById('hrefBase64').href=url;
            document.getElementById('base64').value=url;
        }

        generateChart(type, data, options);

    });

    // Close
    document.getElementById('close-preview-chart').addEventListener('click', function(event) {
        modalPreview.style.display = 'none'; 
    });
         
    // Close modal when is clicked outsite of it
    window.addEventListener('click', function(event) {
        if (event.target == modalPreview) {
            modalPreview.style.display = 'none';
        }
    });

    // Save chart
    document.getElementById('save').addEventListener('click', function(event) {
        event.preventDefault();

        const data = {img: document.getElementById('base64').value}; 

        postData(url + 'chart/save',data).then(function(result) {
            location.reload();
        });
    });
    
});

// Helper functions
function postData(url = '', data = {}) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then( resp => resp.json())
    .then( resp => {
        return resp;

        
    });
}  

function fillData(data) {
    let allStudentIds = data.map(x=>x.fn);

    // Fill globals variable studentIds with all fns distincted
    studentIds = Array.from(new Set(allStudentIds));

    // Fill dropdown
    studentIds.forEach(fn => {
        let sel = document.getElementById('all-student');
        let opt = document.createElement('option');
        opt.appendChild( document.createTextNode(fn) );
        opt.value = fn; 
        sel.appendChild(opt);
    });

    // Fill x coordinates with all fns by default
    let x = document.getElementById('x-data');
    fillTextBox(x, studentIds);

    // Fill dropdown with all categories from database. 
    let allCategories = data.map(x => {
        let obj = {
            id: x.category_id + '_' + x.stage,
            name: x.category_name + ' ' + x.stage
        }
        
        return obj;
    });

    ids = Array.from(new Set(allCategories.map(item => item.id)));

    categories = [];
    ids.forEach(id => {
        categories.push(allCategories.filter(z => z.id == id)[0]);
    })

    genders = studentIds.map(x => data.filter(id=>id.fn == x)[0].gender);
    genders = Array.from(new Set(genders));

    // Add y coord
    createColumnData();

    student_structure = studentIds.map(x => {
        //all student info
        let curr = data.filter(id=>id.fn == x);

        let prettyFormat = {
            id: curr[0].fn,
            gender: curr[0].gender,
            hws: curr.filter(y=>y.category_id == 1).map(z=> {
                let xsa = { stage: z.stage, mark: z.mark_value};
                return xsa;
            }),
            ref: curr.filter(y=>y.category_id == 2).map(z=> {
                let xsa = { stage: z.stage, mark: z.mark_value};
                return xsa;
            }),
            project: curr.filter(y=>y.category_id == 3).map(z=> {
                let xsa = { stage: z.stage, mark: z.mark_value};
                return xsa;
            }),
        }
        return prettyFormat;
    });
}

function generateChart(chart, data, options) {
    let wrapper = document.getElementById('generate');
    wrapper.innerHTML = '';

    let canv = document.createElement('canvas');
    canv.id = 'customChart';
    wrapper.appendChild(canv);

    boxChart = new Chart(canv, {
        type: chart,
        data: data,
        options: options
        
    });   
}

function fillTextBox(data, studentIds) {
    data.innerHTML = '';

    studentIds.forEach( x =>{
        let p = document.createElement('p');
        if(x == undefined) {
            x = 0;
        }
        p.innerHTML = x;
        data.appendChild(p);
    });
}

function addRow(tableID, img) {
    // Get a reference to the table
    let tableRef = document.getElementById(tableID);
  
    // Insert a row at the end of the table
    let newRow = tableRef.insertRow(-1);
  
    // Insert a cell in the row at index 0
    let newCell = newRow.insertCell(0);
  
    // Append a text node to the cell
    let elem = document.createElement('img');
    elem.setAttribute('src', img['img']);

    newCell.appendChild(elem);

    newCell = newRow.insertCell(1);

    if(img['is_visible'] == 0) {
        newCell.innerHTML +=  "<a class='btn md success' href=" + url + "chart/changeVisibility?id=" + img['chart_id']+"&visible=1'>Добави</a>";
    } else {
        newCell.innerHTML +=  "<a class='btn md danger' href=" + url + "chart/changeVisibility?id=" + img['chart_id']+"&visible=0'>Премахни</a>";
    }
    
    newCell.innerHTML +=  "<a class='btn md danger' href=" + url + "chart/delete?id="+img['chart_id']+">Изтрий</a>";
}
  
function createColumnData() {
    

    let row = document.getElementById('tr-x');
    let cell = row.insertCell(-1);

    createLabel(cell, 'Y координати');
    createInput(cell, 'y-label-'+count, 'text');

    row = document.getElementById('tr-dropdown');
    cell = row.insertCell(-1);

    createDropdown(cell, 'y-dropdown-'+count, categories);

    row = document.getElementById('tr-data');
    cell = row.insertCell(-1);

    createTextArea(cell, 'y-data-'+count, '...');

    count++;

    document.getElementById('y-dropdown-1').addEventListener('change', function(event){   

        if(document.getElementById('x-coord').value == 3) {
            // gender
            let data = getDataByGender();
            let x = document.getElementById('y-data-1');
            fillTextBox(x, data);

        } else if ( document.getElementById('x-coord').value == 1){
            let elem = document.getElementById('y-dropdown-1');
            let category_stage = elem.options[elem.selectedIndex].value.split('_');
        
            let category =  category_stage[0];
            let stage =  category_stage[1];    

            let data = [];
            if(category == 1) {
                data = student_structure.map(st => st.hws.filter(x=>x.stage == stage).map(x=>x.mark)[0]);
            } else if(category == 2) {
                data = student_structure.map(st => st.ref.filter(x=>x.stage == stage).map(x=>x.mark)[0]);
            } else if(category == 3 ) {
                data = student_structure.map(st => st.project.filter(x=>x.stage == stage).map(x=>x.mark)[0]);    
            }

            let x = document.getElementById('y-data-1');
            fillTextBox(x, data);
            
        } else {
            let data = getDropDownData('y-dropdown-1');
            let x = document.getElementById('y-data-1');
            fillTextBox(x, data);
        }
        
  
    });

    let dropdownYcord = document.getElementById('y-dropdown-2');
    if (dropdownYcord != undefined) {
        dropdownYcord.addEventListener('change', function(event){   
        let data = getDropDownData('y-dropdown-2');
        let x = document.getElementById('y-data-2');
        fillTextBox(x, data);
    });
    }
}

function getDropDownData(id) {
    let elem = document.getElementById(id);
    let category_stage = elem.options[elem.selectedIndex].value.split('_');

    let category =  category_stage[0];
    let stage =  category_stage[1];    

    // Fill text 
    let values = [];

    let selected = document.getElementById('x-coord').value;

    if(selected == 1 || selected == 2) {
        if(selected == 1) {
            values = studentIds;
        } else if(selected == 2) {
            let collection = document.getElementById('all-student').selectedOptions;
            for (let i=0; i<collection.length; i++) {
                values.push(collection[i].label);
            }
        } else {
    
        }
    
        if(category == 1) {
            return student_structure.filter(x=>values.includes(x.id)).map(st => st.hws.filter(x=>x.stage == stage).map(x=>x.mark)[0]);
        } else if(category == 2) {
            return student_structure.filter(x=>values.includes(x.id)).map(st => st.project.filter(x=>x.stage == stage).map(x=>x.mark)[0]);
        } else if(category == 3 ) {
            return student_structure.filter(x=>values.includes(x.id)).map(st => st.ref.filter(x=>x.stage == stage).map(x=>x.mark)[0]);    
        }

    } else {
        return getDataByGender();
    }
}

function average (numbers) {
    let values = numbers.reduce(function(prev, curr) {
        return prev.concat(curr.split(' ').map(Number));
    }, []);

    let sum = values.reduce((previous, current) => current += parseFloat(previous));
    return (sum / values.length).toFixed(2);
}

function deleteColumnData() {
    let row = document.getElementById('tr-x');
    row.deleteCell(-1);

    row = document.getElementById('tr-dropdown');
    row.deleteCell(-1);

    row = document.getElementById('tr-data');
    row.deleteCell(-1);

    count--;
}

function createLabel(cell, text) {
    let label = document.createElement('label');
    label.innerHTML = text;
    cell.appendChild(label);
}

function createInput(cell, name, type, value) {
    let input = document.createElement('input');
    input.setAttribute('name', name);
    input.setAttribute('id', name);
    input.setAttribute('type', type);

    if(value != undefined) {
        input.setAttribute('value', value);
    }

    cell.appendChild(input);    
}

function createDropdown(cell, name, categories) {
    let selectList = document.createElement('select');

    selectList.setAttribute('name', name);
    selectList.setAttribute('id', name);

    let defaultOption = document.createElement('option');
    defaultOption.value = '0';
    defaultOption.text = 'Изберете координати';
    selectList.appendChild(defaultOption);

    //Create and append the options
    categories.forEach(elem => {
        let option = document.createElement('option');
        option.value = elem.id;
        option.text = elem.name;
        selectList.appendChild(option);
    });

    cell.appendChild(selectList);
}

function createTextArea(cell, name, data) {
    cell.setAttribute('id', name);
    cell.innerHTML = data;
}

function getDataByGender() {
    let men = student_structure.filter(x=>x.gender == 'Мъж');
    let women = student_structure.filter(x=>x.gender == 'Жена');

    let elem = document.getElementById('y-dropdown-1');
    let category_stage = elem.options[elem.selectedIndex].value.split('_');

    let category =  category_stage[0];
    let stage =  category_stage[1];    

    let m,w;
    if(category == 1) {
        m = men.map(st => st.hws.filter(x=>x.stage == stage).map(x=>x.mark)[0]);
        w = women.map(st => st.hws.filter(x=>x.stage == stage).map(x=>x.mark)[0]);
    } else if(category == 2) {
        m = men.map(st => st.project.filter(x=>x.stage == stage).map(x=>x.mark)[0]);
        w = women.map(st => st.project.filter(x=>x.stage == stage).map(x=>x.mark)[0]);
    } else if(category == 3 ) {
        m = men.map(st => st.ref.filter(x=>x.stage == stage).map(x=>x.mark)[0]);    
        w = women.map(st => st.ref.filter(x=>x.stage == stage).map(x=>x.mark)[0]);    
    }

    let data = [];
    data.push(average(m));
    data.push(average(w));
    return data;
}


