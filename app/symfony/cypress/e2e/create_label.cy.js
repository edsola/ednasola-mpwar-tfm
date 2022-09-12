describe('Create new ticket test', () => {
  const labelName = 'label test';
  const email = 'admin@admin.com';
  const pass = 'admin12345';

  before(() =>  {
    cy.visit('http://localhost:1000/login')
    cy.get('input[type=email]').type(email)
    cy.get('input[type=password]').type(pass)
    cy.get('button[type=submit]').click()
    cy.visit('http://localhost:1000/admin/labels')
  })

  context('Check page info', () => {
    it('Check content, visibility and style', () => {
      cy.get('nav').should('be.visible')
      cy.get('h1').should('contain', 'Labels')
      cy.get('table').should('be.visible')
      cy.get('#labelFormButton')
          .should('contain', 'Add new')
          .and('have.class', 'btn-gradient')
      cy.get('#labelForm').should('not.be.visible')
    })
  })

  context('Check form', () => {
    it('Display create label form', () => {
      cy.get('#labelFormButton').click()
      cy.get('#labelForm').should('be.visible')
    })

    it('Check content label form', () => {
      cy.get('button[type=submit]').should('contain', 'Create')
      cy.get('input[type=text').should('be.visible')
    })
  })

  context('Create new label', () => {
    it('Create label', () => {
      cy.get('input[id=label_name]')
          .type(labelName)
          .should('have.value', labelName)
      cy.get('form').submit()
    })
  })
})