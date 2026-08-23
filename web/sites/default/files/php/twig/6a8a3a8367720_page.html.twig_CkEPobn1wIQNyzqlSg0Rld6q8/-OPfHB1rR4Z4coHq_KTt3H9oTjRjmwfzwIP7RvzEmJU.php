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

/* themes/custom/cfc_media_hub/templates/page.html.twig */
class __TwigTemplate_da8ef0817d1a54a6bb48e279a876bc9f extends Template
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
        // line 16
        yield "<div class=\"min-h-screen w-full flex flex-col\">

  ";
        // line 18
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "header", [], "any", false, false, true, 18), "html", null, true);
        yield "

  ";
        // line 20
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 20)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 21
            yield "    <div class=\"mx-auto w-full max-w-[1440px] px-12 pt-4 text-sm text-[color:var(--ink-500)]\">
      ";
            // line 22
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 22), "html", null, true);
            yield "
    </div>
  ";
        }
        // line 25
        yield "
  ";
        // line 26
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 26)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 27
            yield "    <div class=\"mx-auto w-full max-w-[1440px] px-12 pt-4\">
      ";
            // line 28
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 28), "html", null, true);
            yield "
    </div>
  ";
        }
        // line 31
        yield "
  ";
        // line 32
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 32)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 33
            yield "    <div class=\"mx-auto w-full max-w-[1440px] px-12 pt-4\">
      ";
            // line 34
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "help", [], "any", false, false, true, 34), "html", null, true);
            yield "
    </div>
  ";
        }
        // line 37
        yield "
  <main class=\"flex-1\">
    <a id=\"main-content\" tabindex=\"-1\"></a>

    ";
        // line 41
        if (((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 41)) && $tmp instanceof Markup ? (string) $tmp : $tmp) || (($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 41)) && $tmp instanceof Markup ? (string) $tmp : $tmp))) {
            // line 42
            yield "      <div class=\"mx-auto flex w-full max-w-[1440px] gap-10 px-12 py-10\">
        ";
            // line 43
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 43)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 44
                yield "          <aside class=\"w-64 shrink-0\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 44), "html", null, true);
                yield "</aside>
        ";
            }
            // line 46
            yield "        <div class=\"min-w-0 flex-1\">";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 46), "html", null, true);
            yield "</div>
        ";
            // line 47
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 47)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 48
                yield "          <aside class=\"w-64 shrink-0\">";
                yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 48), "html", null, true);
                yield "</aside>
        ";
            }
            // line 50
            yield "      </div>
    ";
        } else {
            // line 52
            yield "      ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 52), "html", null, true);
            yield "
    ";
        }
        // line 54
        yield "  </main>

  ";
        // line 56
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 56), "html", null, true);
        yield "

</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/cfc_media_hub/templates/page.html.twig";
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
        return array (  138 => 56,  134 => 54,  128 => 52,  124 => 50,  118 => 48,  116 => 47,  111 => 46,  105 => 44,  103 => 43,  100 => 42,  98 => 41,  92 => 37,  86 => 34,  83 => 33,  81 => 32,  78 => 31,  72 => 28,  69 => 27,  67 => 26,  64 => 25,  58 => 22,  55 => 21,  53 => 20,  48 => 18,  44 => 16,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/cfc_media_hub/templates/page.html.twig", "/var/www/html/web/themes/custom/cfc_media_hub/templates/page.html.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 20];
        static $filters = ["escape" => 18];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "if"],
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
