describe('Login test', () => {
  const email = 'admin@admin.com';
  const pass = 'admin12345';

  beforeEach(() =>  {
    cy.visit('http://localhost:1000/login')
  })

  context('Check page info', () => {
    it('Check content and visibility', () => {
      cy.get('h1').should('contain', 'TicketsApp')
      cy.get('label[for=inputEmail]').should('contain', 'Email')
      cy.get('label[for=inputPassword]').should('contain', 'Password')
      cy.get('button[type=submit]')
          .should('contain', 'Sign in')
          .and('be.visible')
    })

    it('Check style', () => {
      cy.get('button[type=submit]').should('have.class', 'btn-gradient')
    })
  })

  context('Login action', () => {
    it('Login with valid credentials', () => {
      cy.get('input[type=email]')
          .type(email)
          .should('have.value', email)
      cy.get('input[type=password]')
          .type(pass)
          .should('have.value', pass)
      cy.get('button[type=submit]').click()

      cy.url().should('eq', 'http://localhost:1000/')
      cy.request('http://localhost:1000/').then((resp) => {
        expect(resp.status).to.eq(200)
      })
    })

    it('Login with invalid credentials', () => {
      cy.get('input[type=email]').type('test@test.com')
      cy.get('input[type=password]').type(pass)
      cy.get('button[type=submit]').click()

      cy.get('.alert')
          .should('contain', 'Invalid credentials.')
          .and('have.class', 'alert-danger')
      cy.url().should('eq', 'http://localhost:1000/login')
    })
  })
})