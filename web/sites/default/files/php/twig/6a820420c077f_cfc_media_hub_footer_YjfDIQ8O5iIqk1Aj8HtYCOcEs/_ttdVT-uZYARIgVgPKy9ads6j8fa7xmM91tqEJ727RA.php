<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:footer */
class __TwigTemplate_1b364f180bcc98c96a2f8b59161de75d extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--footer"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:footer"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:footer"));
        yield "<footer class=\"bg-neutral-950 text-white/80 pt-20 pb-10\">
  <div class=\"max-w-[1440px] mx-auto px-12\">

    ";
        // line 5
        yield "    <div class=\"mb-14 pb-14 border-b border-white/10\" x-data=\"{ subscribed: false, email: \x27\x27 }\">
      <div class=\"grid grid-cols-12 gap-12 items-center\">
        <div class=\"col-span-5\">
          <div class=\"text-[11px] uppercase tracking-[0.18em] text-[#9F5434] font-bold mb-3\">Newsletter</div>
          <h2 class=\"tracking-tight text-white mb-3\" style=\"font-size: 28px; font-weight: 600; letter-spacing: -0.02em;\">Stay informed.</h2>
          <p class=\"text-white/55 leading-relaxed text-[14px]\">Receive CFC Media Hub news, reports and editorial updates directly in your inbox.</p>
        </div>
        <div class=\"col-span-7 flex items-center justify-end\">
          <div x-show=\"subscribed\" x-cloak class=\"flex items-center gap-3 bg-white/[0.06] border border-white/10 rounded-2xl px-6 py-4\">
            <span class=\"text-[#9F5434] text-lg\">&#10003;</span>
            <div>
              <div class=\"text-white text-[14px] font-semibold\">You\x27re subscribed.</div>
              <div class=\"text-white/50 text-[12px]\">Expect updates and reports in your inbox.</div>
            </div>
          </div>
          <form x-show=\"!subscribed\" x-on:submit.prevent=\"subscribed = true\" class=\"flex gap-3 w-full max-w-[500px]\">
            <label for=\"footer-newsletter-email\" class=\"sr-only\">Email address</label>
            <input
              id=\"footer-newsletter-email\"
              type=\"email\"
              name=\"email\"
              x-model=\"email\"
              required
              placeholder=\"Enter your email address\"
              class=\"flex-1 bg-white/[0.06] border border-white/15 rounded-xl px-5 py-3.5 text-[14px] text-white placeholder:text-white/35 focus:outline-none focus:border-white/30 transition-colors\"
            />
            <button type=\"submit\" class=\"bg-[#9F5434] hover:bg-[#8A4A2E] text-white px-6 py-3.5 rounded-xl text-[13px] font-semibold transition-colors shrink-0\">
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class=\"grid grid-cols-12 gap-12 pb-14 border-b border-white/10\">
      <div class=\"col-span-4\">
        <a href=\"";
        // line 41
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"mb-6 block\">
          <img src=\"";
        // line 42
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["logo_url"] ?? null), "html", null, true);
        yield "\" alt=\"CFC Media Hub\" class=\"h-20 w-auto brightness-0 invert\" />
        </a>
        <p class=\"text-[14px] text-white/60 leading-relaxed max-w-[320px]\">
          CFC Media Hub — workspaces, meeting rooms and a studio for international journalists.
        </p>
        <div class=\"mt-6 text-[13px] text-white/50 leading-relaxed\">
          Located in Casablanca Finance City<br />
          Main Street – CFC Cube, 2nd Floor<br />
          Casablanca &middot; Morocco
        </div>
      </div>

      ";
        // line 54
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["columns"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
            // line 55
            yield "        <div class=\"col-span-2\">
          <div class=\"text-[12px] uppercase tracking-wide text-white font-semibold mb-4\">";
            // line 56
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["column"], "title", [], "any", false, false, true, 56), "html", null, true);
            yield "</div>
          <ul class=\"space-y-2.5\">
            ";
            // line 58
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "links", [], "any", false, false, true, 58));
            foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
                // line 59
                yield "              <li>
                <a href=\"";
                // line 60
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["link"], "url", [], "any", false, false, true, 60), "html", null, true);
                yield "\" class=\"text-[13px] text-white/60 hover:text-white transition-colors\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["link"], "label", [], "any", false, false, true, 60), "html", null, true);
                yield "</a>
              </li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['link'], $context['_parent']);
            $context = array_intersect_key($context, $_parent);
            $context += $_parent;
            // line 63
            yield "          </ul>
        </div>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['column'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 66
        yield "    </div>

    <div class=\"pt-6 space-y-3\">
      <div class=\"text-[12px] text-white/35 leading-relaxed max-w-[760px]\">
        An initiative by CFCA, in partnership with the Région Casablanca-Settat and the Ministry of Youth, Culture and Communication.
      </div>
      <div class=\"flex items-center justify-between text-[12px] text-white/45\">
        <div>&copy; 2026 CFC Media Hub. Operated by Casablanca Finance City Authority.</div>
        <div class=\"flex items-center gap-6\">
          <button type=\"button\" class=\"hover:text-white transition-colors\">EN</button>
          <button type=\"button\" class=\"hover:text-white transition-colors\">FR</button>
          <button type=\"button\" class=\"hover:text-white transition-colors\">AR</button>
        </div>
      </div>
    </div>
  </div>
</footer>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["home_url", "logo_url", "columns"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:footer";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  149 => 66,  140 => 63,  128 => 60,  125 => 59,  121 => 58,  116 => 56,  113 => 55,  109 => 54,  94 => 42,  90 => 41,  52 => 5,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:footer", "themes/custom/cfc_media_hub/components/footer/footer.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["for" => 54];
        static $filters = ["escape" => 41];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "for"],
                [0 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
